<?php
namespace SoftUni\Core;

use SoftUni\Core\MVC\MVCContextInterface;
use SoftUni\Core\MVC\SessionInterface;
use SoftUni\Services\ResponseServiceInterface;

class Application
{
    const VENDOR_NAMESPACE = 'SoftUni';
    const CONTROLLERS_NAMESPACE = 'Controllers';
    const CONTROLLERS_SUFFIX = 'Controller';
    const NAMESPACE_SEPARATOR = '\\';

    private $mvcContext;
    private $responseService;

    private $dependencies = [];
    private $resolvedDependencies = [];

    public function __construct(MVCContextInterface $mvcContext,ResponseServiceInterface $responseService)
    {
        $this->mvcContext = $mvcContext;
        $this->responseService = $responseService;
    }

    public function start()
    {
        $controllerName = $this->mvcContext->getController();

        $controllerFullQualifiedName =
           // self::NAMESPACE_SEPARATOR.
            self::VENDOR_NAMESPACE
            . self::NAMESPACE_SEPARATOR
            . self::CONTROLLERS_NAMESPACE
            . self::NAMESPACE_SEPARATOR
            . ucfirst($controllerName)
            . self::CONTROLLERS_SUFFIX;

      /*  $controllerFileName =
             self::CONTROLLERS_NAMESPACE
            . self::NAMESPACE_SEPARATOR
            . ucfirst($controllerName)
            . self::CONTROLLERS_SUFFIX;
*/
        $controllerFileName =
            '.'  . DIRECTORY_SEPARATOR.
            self::CONTROLLERS_NAMESPACE
            . DIRECTORY_SEPARATOR
            . ucfirst($controllerName)
            . self::CONTROLLERS_SUFFIX;


        $actionName = $this->mvcContext->getAction(); // loginPost

        $args = $this->mvcContext->getArguments(); // []


        if(!file_exists ($controllerFileName.".php")){

            $this->responseService->redirect_static("errors/404.html");
        }

        try{
            $refMethod = new \ReflectionMethod(
                $controllerFullQualifiedName,
                $actionName
            );
       }catch (\ReflectionException $exception){
            $this->responseService->redirect_static("errors/404.html");

        }



        $parameters = $refMethod->getParameters();

        foreach ($parameters as $parameter) {
            $parameterClass = $parameter->getClass();

            if ($parameterClass !== null) {
                $className = $parameterClass->getName();
                if (!$parameterClass->isInterface()) {
                    $instance = $this->mapForm($_POST, $parameterClass);
                } else {
                    $instance = $this->resolve($this->dependencies[$className]);
                }
                $args[] = $instance;
            }
        }

        if (class_exists($controllerFullQualifiedName)) {
            $controller = $this->resolve($controllerFullQualifiedName);
            if(call_user_func_array(
                [
                    $controller,
                    $actionName
                ],
                $args
            )=== false){
                // non- existing action
                $this->responseService->redirect_static("errors/404.html");
            }
        }else{
            //non-existing class, izvikvame statis4na strania primernp
            $this->responseService->redirect_static("errors/404.html");
        }
    }

    public function registerDependency($interfaceName, $implementationName)
    {
        $this->dependencies[$interfaceName] = $implementationName;
    }

    public function addClass($interfaceName, $instance)
    {

        $implementationName = get_class($instance);
        $this->dependencies[$interfaceName] = $implementationName;
        $this->resolvedDependencies[$implementationName] = $instance;
    }

    private function resolve($className)
    {
        if (array_key_exists($className, $this->resolvedDependencies)) {
            return $this->resolvedDependencies[$className];
        }

        $refClass = new \ReflectionClass($className);
        $constructor = $refClass->getConstructor();
        if ($constructor === null) {
            $instance = new $className();
            return $instance;
        }

        $parameters = $constructor->getParameters();
        $parametersToInstantiate = [];
        foreach ($parameters as $parameter) {
            $interface = $parameter->getClass();
            if ($interface === null) {
                throw new \Exception("Parameters cannot be primitive in order the DI to work");
            }

            $interfaceName = $interface->getName(); // 'DatabaseInterface'

            $implementation = $this->dependencies[$interfaceName]; // 'Database'
            if (array_key_exists($implementation, $this->resolvedDependencies)) {
                $implementationInstance = $this->resolvedDependencies[$implementation];
            } else {
                $implementationInstance = $this->resolve($implementation);
                $this->resolvedDependencies[$implementation] = $implementationInstance;
            }

            $parametersToInstantiate[] = $implementationInstance;
        }
        $result = $refClass->newInstanceArgs($parametersToInstantiate);
        $this->resolvedDependencies[$className] = $result;

        return $result;
    }

    private function mapForm($form, \ReflectionClass $parameterClass)
    {
        $className = $parameterClass->getName();
        $instance = new $className();
        foreach ($parameterClass->getProperties() as $field) {
            $field->setAccessible(true);
            if (array_key_exists($field->getName(), $form)) {
                //$field->setValue($instance, htmlspecialchars($form[$field->getName()]));
                $field->setValue($instance, $form[$field->getName()]);

            }
        }

        return $instance;
    }
}