<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbb918eb47bd377324f4561bb425b0e5e
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        'b33e3d135e5d9e47d845c576147bda89' => __DIR__ . '/..' . '/php-di/php-di/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'superbot\\Telegram\\' => 18,
            'superbot\\App\\' => 13,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
            'Psr\\Container\\' => 14,
            'PhpDocReader\\' => 13,
        ),
        'L' => 
        array (
            'Laravel\\SerializableClosure\\' => 28,
        ),
        'I' => 
        array (
            'Invoker\\' => 8,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'D' => 
        array (
            'DI\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'superbot\\Telegram\\' => 
        array (
            0 => __DIR__ . '/../..' . '/superbot/Telegram',
        ),
        'superbot\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'PhpDocReader\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/phpdoc-reader/src/PhpDocReader',
        ),
        'Laravel\\SerializableClosure\\' => 
        array (
            0 => __DIR__ . '/..' . '/laravel/serializable-closure/src',
        ),
        'Invoker\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/invoker/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'DI\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-di/php-di/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'DI\\Annotation\\Inject' => __DIR__ . '/..' . '/php-di/php-di/src/Annotation/Inject.php',
        'DI\\Annotation\\Injectable' => __DIR__ . '/..' . '/php-di/php-di/src/Annotation/Injectable.php',
        'DI\\CompiledContainer' => __DIR__ . '/..' . '/php-di/php-di/src/CompiledContainer.php',
        'DI\\Compiler\\Compiler' => __DIR__ . '/..' . '/php-di/php-di/src/Compiler/Compiler.php',
        'DI\\Compiler\\ObjectCreationCompiler' => __DIR__ . '/..' . '/php-di/php-di/src/Compiler/ObjectCreationCompiler.php',
        'DI\\Compiler\\RequestedEntryHolder' => __DIR__ . '/..' . '/php-di/php-di/src/Compiler/RequestedEntryHolder.php',
        'DI\\Container' => __DIR__ . '/..' . '/php-di/php-di/src/Container.php',
        'DI\\ContainerBuilder' => __DIR__ . '/..' . '/php-di/php-di/src/ContainerBuilder.php',
        'DI\\Definition\\ArrayDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/ArrayDefinition.php',
        'DI\\Definition\\ArrayDefinitionExtension' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/ArrayDefinitionExtension.php',
        'DI\\Definition\\AutowireDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/AutowireDefinition.php',
        'DI\\Definition\\DecoratorDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/DecoratorDefinition.php',
        'DI\\Definition\\Definition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Definition.php',
        'DI\\Definition\\Dumper\\ObjectDefinitionDumper' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Dumper/ObjectDefinitionDumper.php',
        'DI\\Definition\\EnvironmentVariableDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/EnvironmentVariableDefinition.php',
        'DI\\Definition\\Exception\\InvalidAnnotation' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Exception/InvalidAnnotation.php',
        'DI\\Definition\\Exception\\InvalidDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Exception/InvalidDefinition.php',
        'DI\\Definition\\ExtendsPreviousDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/ExtendsPreviousDefinition.php',
        'DI\\Definition\\FactoryDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/FactoryDefinition.php',
        'DI\\Definition\\Helper\\AutowireDefinitionHelper' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Helper/AutowireDefinitionHelper.php',
        'DI\\Definition\\Helper\\CreateDefinitionHelper' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Helper/CreateDefinitionHelper.php',
        'DI\\Definition\\Helper\\DefinitionHelper' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Helper/DefinitionHelper.php',
        'DI\\Definition\\Helper\\FactoryDefinitionHelper' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Helper/FactoryDefinitionHelper.php',
        'DI\\Definition\\InstanceDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/InstanceDefinition.php',
        'DI\\Definition\\ObjectDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/ObjectDefinition.php',
        'DI\\Definition\\ObjectDefinition\\MethodInjection' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/ObjectDefinition/MethodInjection.php',
        'DI\\Definition\\ObjectDefinition\\PropertyInjection' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/ObjectDefinition/PropertyInjection.php',
        'DI\\Definition\\Reference' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Reference.php',
        'DI\\Definition\\Resolver\\ArrayResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/ArrayResolver.php',
        'DI\\Definition\\Resolver\\DecoratorResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/DecoratorResolver.php',
        'DI\\Definition\\Resolver\\DefinitionResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/DefinitionResolver.php',
        'DI\\Definition\\Resolver\\EnvironmentVariableResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/EnvironmentVariableResolver.php',
        'DI\\Definition\\Resolver\\FactoryResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/FactoryResolver.php',
        'DI\\Definition\\Resolver\\InstanceInjector' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/InstanceInjector.php',
        'DI\\Definition\\Resolver\\ObjectCreator' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/ObjectCreator.php',
        'DI\\Definition\\Resolver\\ParameterResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/ParameterResolver.php',
        'DI\\Definition\\Resolver\\ResolverDispatcher' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Resolver/ResolverDispatcher.php',
        'DI\\Definition\\SelfResolvingDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/SelfResolvingDefinition.php',
        'DI\\Definition\\Source\\AnnotationBasedAutowiring' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/AnnotationBasedAutowiring.php',
        'DI\\Definition\\Source\\Autowiring' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/Autowiring.php',
        'DI\\Definition\\Source\\DefinitionArray' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/DefinitionArray.php',
        'DI\\Definition\\Source\\DefinitionFile' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/DefinitionFile.php',
        'DI\\Definition\\Source\\DefinitionNormalizer' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/DefinitionNormalizer.php',
        'DI\\Definition\\Source\\DefinitionSource' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/DefinitionSource.php',
        'DI\\Definition\\Source\\MutableDefinitionSource' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/MutableDefinitionSource.php',
        'DI\\Definition\\Source\\NoAutowiring' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/NoAutowiring.php',
        'DI\\Definition\\Source\\ReflectionBasedAutowiring' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/ReflectionBasedAutowiring.php',
        'DI\\Definition\\Source\\SourceCache' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/SourceCache.php',
        'DI\\Definition\\Source\\SourceChain' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/Source/SourceChain.php',
        'DI\\Definition\\StringDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/StringDefinition.php',
        'DI\\Definition\\ValueDefinition' => __DIR__ . '/..' . '/php-di/php-di/src/Definition/ValueDefinition.php',
        'DI\\DependencyException' => __DIR__ . '/..' . '/php-di/php-di/src/DependencyException.php',
        'DI\\FactoryInterface' => __DIR__ . '/..' . '/php-di/php-di/src/FactoryInterface.php',
        'DI\\Factory\\RequestedEntry' => __DIR__ . '/..' . '/php-di/php-di/src/Factory/RequestedEntry.php',
        'DI\\Invoker\\DefinitionParameterResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Invoker/DefinitionParameterResolver.php',
        'DI\\Invoker\\FactoryParameterResolver' => __DIR__ . '/..' . '/php-di/php-di/src/Invoker/FactoryParameterResolver.php',
        'DI\\NotFoundException' => __DIR__ . '/..' . '/php-di/php-di/src/NotFoundException.php',
        'DI\\Proxy\\ProxyFactory' => __DIR__ . '/..' . '/php-di/php-di/src/Proxy/ProxyFactory.php',
        'GuzzleHttp\\BodySummarizer' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/BodySummarizer.php',
        'GuzzleHttp\\BodySummarizerInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/BodySummarizerInterface.php',
        'GuzzleHttp\\Client' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Client.php',
        'GuzzleHttp\\ClientInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/ClientInterface.php',
        'GuzzleHttp\\ClientTrait' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/ClientTrait.php',
        'GuzzleHttp\\Cookie\\CookieJar' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/CookieJar.php',
        'GuzzleHttp\\Cookie\\CookieJarInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/CookieJarInterface.php',
        'GuzzleHttp\\Cookie\\FileCookieJar' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/FileCookieJar.php',
        'GuzzleHttp\\Cookie\\SessionCookieJar' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/SessionCookieJar.php',
        'GuzzleHttp\\Cookie\\SetCookie' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Cookie/SetCookie.php',
        'GuzzleHttp\\Exception\\BadResponseException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/BadResponseException.php',
        'GuzzleHttp\\Exception\\ClientException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/ClientException.php',
        'GuzzleHttp\\Exception\\ConnectException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/ConnectException.php',
        'GuzzleHttp\\Exception\\GuzzleException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/GuzzleException.php',
        'GuzzleHttp\\Exception\\InvalidArgumentException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/InvalidArgumentException.php',
        'GuzzleHttp\\Exception\\RequestException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/RequestException.php',
        'GuzzleHttp\\Exception\\ServerException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/ServerException.php',
        'GuzzleHttp\\Exception\\TooManyRedirectsException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/TooManyRedirectsException.php',
        'GuzzleHttp\\Exception\\TransferException' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Exception/TransferException.php',
        'GuzzleHttp\\HandlerStack' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/HandlerStack.php',
        'GuzzleHttp\\Handler\\CurlFactory' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlFactory.php',
        'GuzzleHttp\\Handler\\CurlFactoryInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlFactoryInterface.php',
        'GuzzleHttp\\Handler\\CurlHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlHandler.php',
        'GuzzleHttp\\Handler\\CurlMultiHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/CurlMultiHandler.php',
        'GuzzleHttp\\Handler\\EasyHandle' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/EasyHandle.php',
        'GuzzleHttp\\Handler\\HeaderProcessor' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/HeaderProcessor.php',
        'GuzzleHttp\\Handler\\MockHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/MockHandler.php',
        'GuzzleHttp\\Handler\\Proxy' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/Proxy.php',
        'GuzzleHttp\\Handler\\StreamHandler' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Handler/StreamHandler.php',
        'GuzzleHttp\\MessageFormatter' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/MessageFormatter.php',
        'GuzzleHttp\\MessageFormatterInterface' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/MessageFormatterInterface.php',
        'GuzzleHttp\\Middleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Middleware.php',
        'GuzzleHttp\\Pool' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Pool.php',
        'GuzzleHttp\\PrepareBodyMiddleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/PrepareBodyMiddleware.php',
        'GuzzleHttp\\Promise\\AggregateException' => __DIR__ . '/..' . '/guzzlehttp/promises/src/AggregateException.php',
        'GuzzleHttp\\Promise\\CancellationException' => __DIR__ . '/..' . '/guzzlehttp/promises/src/CancellationException.php',
        'GuzzleHttp\\Promise\\Coroutine' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Coroutine.php',
        'GuzzleHttp\\Promise\\Create' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Create.php',
        'GuzzleHttp\\Promise\\Each' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Each.php',
        'GuzzleHttp\\Promise\\EachPromise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/EachPromise.php',
        'GuzzleHttp\\Promise\\FulfilledPromise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/FulfilledPromise.php',
        'GuzzleHttp\\Promise\\Is' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Is.php',
        'GuzzleHttp\\Promise\\Promise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Promise.php',
        'GuzzleHttp\\Promise\\PromiseInterface' => __DIR__ . '/..' . '/guzzlehttp/promises/src/PromiseInterface.php',
        'GuzzleHttp\\Promise\\PromisorInterface' => __DIR__ . '/..' . '/guzzlehttp/promises/src/PromisorInterface.php',
        'GuzzleHttp\\Promise\\RejectedPromise' => __DIR__ . '/..' . '/guzzlehttp/promises/src/RejectedPromise.php',
        'GuzzleHttp\\Promise\\RejectionException' => __DIR__ . '/..' . '/guzzlehttp/promises/src/RejectionException.php',
        'GuzzleHttp\\Promise\\TaskQueue' => __DIR__ . '/..' . '/guzzlehttp/promises/src/TaskQueue.php',
        'GuzzleHttp\\Promise\\TaskQueueInterface' => __DIR__ . '/..' . '/guzzlehttp/promises/src/TaskQueueInterface.php',
        'GuzzleHttp\\Promise\\Utils' => __DIR__ . '/..' . '/guzzlehttp/promises/src/Utils.php',
        'GuzzleHttp\\Psr7\\AppendStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/AppendStream.php',
        'GuzzleHttp\\Psr7\\BufferStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/BufferStream.php',
        'GuzzleHttp\\Psr7\\CachingStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/CachingStream.php',
        'GuzzleHttp\\Psr7\\DroppingStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/DroppingStream.php',
        'GuzzleHttp\\Psr7\\Exception\\MalformedUriException' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Exception/MalformedUriException.php',
        'GuzzleHttp\\Psr7\\FnStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/FnStream.php',
        'GuzzleHttp\\Psr7\\Header' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Header.php',
        'GuzzleHttp\\Psr7\\HttpFactory' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/HttpFactory.php',
        'GuzzleHttp\\Psr7\\InflateStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/InflateStream.php',
        'GuzzleHttp\\Psr7\\LazyOpenStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/LazyOpenStream.php',
        'GuzzleHttp\\Psr7\\LimitStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/LimitStream.php',
        'GuzzleHttp\\Psr7\\Message' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Message.php',
        'GuzzleHttp\\Psr7\\MessageTrait' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/MessageTrait.php',
        'GuzzleHttp\\Psr7\\MimeType' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/MimeType.php',
        'GuzzleHttp\\Psr7\\MultipartStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/MultipartStream.php',
        'GuzzleHttp\\Psr7\\NoSeekStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/NoSeekStream.php',
        'GuzzleHttp\\Psr7\\PumpStream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/PumpStream.php',
        'GuzzleHttp\\Psr7\\Query' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Query.php',
        'GuzzleHttp\\Psr7\\Request' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Request.php',
        'GuzzleHttp\\Psr7\\Response' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Response.php',
        'GuzzleHttp\\Psr7\\Rfc7230' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Rfc7230.php',
        'GuzzleHttp\\Psr7\\ServerRequest' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/ServerRequest.php',
        'GuzzleHttp\\Psr7\\Stream' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Stream.php',
        'GuzzleHttp\\Psr7\\StreamDecoratorTrait' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/StreamDecoratorTrait.php',
        'GuzzleHttp\\Psr7\\StreamWrapper' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/StreamWrapper.php',
        'GuzzleHttp\\Psr7\\UploadedFile' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/UploadedFile.php',
        'GuzzleHttp\\Psr7\\Uri' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Uri.php',
        'GuzzleHttp\\Psr7\\UriComparator' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/UriComparator.php',
        'GuzzleHttp\\Psr7\\UriNormalizer' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/UriNormalizer.php',
        'GuzzleHttp\\Psr7\\UriResolver' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/UriResolver.php',
        'GuzzleHttp\\Psr7\\Utils' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/Utils.php',
        'GuzzleHttp\\RedirectMiddleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/RedirectMiddleware.php',
        'GuzzleHttp\\RequestOptions' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/RequestOptions.php',
        'GuzzleHttp\\RetryMiddleware' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/RetryMiddleware.php',
        'GuzzleHttp\\TransferStats' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/TransferStats.php',
        'GuzzleHttp\\Utils' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/Utils.php',
        'Invoker\\CallableResolver' => __DIR__ . '/..' . '/php-di/invoker/src/CallableResolver.php',
        'Invoker\\Exception\\InvocationException' => __DIR__ . '/..' . '/php-di/invoker/src/Exception/InvocationException.php',
        'Invoker\\Exception\\NotCallableException' => __DIR__ . '/..' . '/php-di/invoker/src/Exception/NotCallableException.php',
        'Invoker\\Exception\\NotEnoughParametersException' => __DIR__ . '/..' . '/php-di/invoker/src/Exception/NotEnoughParametersException.php',
        'Invoker\\Invoker' => __DIR__ . '/..' . '/php-di/invoker/src/Invoker.php',
        'Invoker\\InvokerInterface' => __DIR__ . '/..' . '/php-di/invoker/src/InvokerInterface.php',
        'Invoker\\ParameterResolver\\AssociativeArrayResolver' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/AssociativeArrayResolver.php',
        'Invoker\\ParameterResolver\\Container\\ParameterNameContainerResolver' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/Container/ParameterNameContainerResolver.php',
        'Invoker\\ParameterResolver\\Container\\TypeHintContainerResolver' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/Container/TypeHintContainerResolver.php',
        'Invoker\\ParameterResolver\\DefaultValueResolver' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/DefaultValueResolver.php',
        'Invoker\\ParameterResolver\\NumericArrayResolver' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/NumericArrayResolver.php',
        'Invoker\\ParameterResolver\\ParameterResolver' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/ParameterResolver.php',
        'Invoker\\ParameterResolver\\ResolverChain' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/ResolverChain.php',
        'Invoker\\ParameterResolver\\TypeHintResolver' => __DIR__ . '/..' . '/php-di/invoker/src/ParameterResolver/TypeHintResolver.php',
        'Invoker\\Reflection\\CallableReflection' => __DIR__ . '/..' . '/php-di/invoker/src/Reflection/CallableReflection.php',
        'Laravel\\SerializableClosure\\Contracts\\Serializable' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Contracts/Serializable.php',
        'Laravel\\SerializableClosure\\Contracts\\Signer' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Contracts/Signer.php',
        'Laravel\\SerializableClosure\\Exceptions\\InvalidSignatureException' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Exceptions/InvalidSignatureException.php',
        'Laravel\\SerializableClosure\\Exceptions\\MissingSecretKeyException' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Exceptions/MissingSecretKeyException.php',
        'Laravel\\SerializableClosure\\Exceptions\\PhpVersionNotSupportedException' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Exceptions/PhpVersionNotSupportedException.php',
        'Laravel\\SerializableClosure\\SerializableClosure' => __DIR__ . '/..' . '/laravel/serializable-closure/src/SerializableClosure.php',
        'Laravel\\SerializableClosure\\Serializers\\Native' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Serializers/Native.php',
        'Laravel\\SerializableClosure\\Serializers\\Signed' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Serializers/Signed.php',
        'Laravel\\SerializableClosure\\Signers\\Hmac' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Signers/Hmac.php',
        'Laravel\\SerializableClosure\\Support\\ClosureScope' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Support/ClosureScope.php',
        'Laravel\\SerializableClosure\\Support\\ClosureStream' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Support/ClosureStream.php',
        'Laravel\\SerializableClosure\\Support\\ReflectionClosure' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Support/ReflectionClosure.php',
        'Laravel\\SerializableClosure\\Support\\SelfReference' => __DIR__ . '/..' . '/laravel/serializable-closure/src/Support/SelfReference.php',
        'Laravel\\SerializableClosure\\UnsignedSerializableClosure' => __DIR__ . '/..' . '/laravel/serializable-closure/src/UnsignedSerializableClosure.php',
        'PhpDocReader\\AnnotationException' => __DIR__ . '/..' . '/php-di/phpdoc-reader/src/PhpDocReader/AnnotationException.php',
        'PhpDocReader\\PhpDocReader' => __DIR__ . '/..' . '/php-di/phpdoc-reader/src/PhpDocReader/PhpDocReader.php',
        'PhpDocReader\\PhpParser\\TokenParser' => __DIR__ . '/..' . '/php-di/phpdoc-reader/src/PhpDocReader/PhpParser/TokenParser.php',
        'PhpDocReader\\PhpParser\\UseStatementParser' => __DIR__ . '/..' . '/php-di/phpdoc-reader/src/PhpDocReader/PhpParser/UseStatementParser.php',
        'Psr\\Container\\ContainerExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerExceptionInterface.php',
        'Psr\\Container\\ContainerInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerInterface.php',
        'Psr\\Container\\NotFoundExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/NotFoundExceptionInterface.php',
        'Psr\\Http\\Client\\ClientExceptionInterface' => __DIR__ . '/..' . '/psr/http-client/src/ClientExceptionInterface.php',
        'Psr\\Http\\Client\\ClientInterface' => __DIR__ . '/..' . '/psr/http-client/src/ClientInterface.php',
        'Psr\\Http\\Client\\NetworkExceptionInterface' => __DIR__ . '/..' . '/psr/http-client/src/NetworkExceptionInterface.php',
        'Psr\\Http\\Client\\RequestExceptionInterface' => __DIR__ . '/..' . '/psr/http-client/src/RequestExceptionInterface.php',
        'Psr\\Http\\Message\\MessageInterface' => __DIR__ . '/..' . '/psr/http-message/src/MessageInterface.php',
        'Psr\\Http\\Message\\RequestFactoryInterface' => __DIR__ . '/..' . '/psr/http-factory/src/RequestFactoryInterface.php',
        'Psr\\Http\\Message\\RequestInterface' => __DIR__ . '/..' . '/psr/http-message/src/RequestInterface.php',
        'Psr\\Http\\Message\\ResponseFactoryInterface' => __DIR__ . '/..' . '/psr/http-factory/src/ResponseFactoryInterface.php',
        'Psr\\Http\\Message\\ResponseInterface' => __DIR__ . '/..' . '/psr/http-message/src/ResponseInterface.php',
        'Psr\\Http\\Message\\ServerRequestFactoryInterface' => __DIR__ . '/..' . '/psr/http-factory/src/ServerRequestFactoryInterface.php',
        'Psr\\Http\\Message\\ServerRequestInterface' => __DIR__ . '/..' . '/psr/http-message/src/ServerRequestInterface.php',
        'Psr\\Http\\Message\\StreamFactoryInterface' => __DIR__ . '/..' . '/psr/http-factory/src/StreamFactoryInterface.php',
        'Psr\\Http\\Message\\StreamInterface' => __DIR__ . '/..' . '/psr/http-message/src/StreamInterface.php',
        'Psr\\Http\\Message\\UploadedFileFactoryInterface' => __DIR__ . '/..' . '/psr/http-factory/src/UploadedFileFactoryInterface.php',
        'Psr\\Http\\Message\\UploadedFileInterface' => __DIR__ . '/..' . '/psr/http-message/src/UploadedFileInterface.php',
        'Psr\\Http\\Message\\UriFactoryInterface' => __DIR__ . '/..' . '/psr/http-factory/src/UriFactoryInterface.php',
        'Psr\\Http\\Message\\UriInterface' => __DIR__ . '/..' . '/psr/http-message/src/UriInterface.php',
        'superbot\\App\\Configs\\DBConfigs' => __DIR__ . '/../..' . '/app/Configs/DBConfigs.php',
        'superbot\\App\\Configs\\GeneralConfigs' => __DIR__ . '/../..' . '/app/Configs/GeneralConfigs.php',
        'superbot\\App\\Controllers\\Controller' => __DIR__ . '/../..' . '/app/Controllers/Controller.php',
        'superbot\\App\\Controllers\\MessageController' => __DIR__ . '/../..' . '/app/Controllers/MessageController.php',
        'superbot\\App\\Controllers\\Messages\\CommandController' => __DIR__ . '/../..' . '/app/Controllers/Messages/CommandController.php',
        'superbot\\App\\Controllers\\Messages\\HomeController' => __DIR__ . '/../..' . '/app/Controllers/Messages/HomeController.php',
        'superbot\\App\\Controllers\\Messages\\PostController' => __DIR__ . '/../..' . '/app/Controllers/Messages/PostController.php',
        'superbot\\App\\Controllers\\Messages\\SearchController' => __DIR__ . '/../..' . '/app/Controllers/Messages/SearchController.php',
        'superbot\\App\\Controllers\\Messages\\SettingsController' => __DIR__ . '/../..' . '/app/Controllers/Messages/SettingsController.php',
        'superbot\\App\\Controllers\\QueryController' => __DIR__ . '/../..' . '/app/Controllers/QueryController.php',
        'superbot\\App\\Controllers\\Query\\BookmarkController' => __DIR__ . '/../..' . '/app/Controllers/Query/BookmarkController.php',
        'superbot\\App\\Controllers\\Query\\HomeController' => __DIR__ . '/../..' . '/app/Controllers/Query/HomeController.php',
        'superbot\\App\\Controllers\\Query\\LeadershipController' => __DIR__ . '/../..' . '/app/Controllers/Query/LeadershipController.php',
        'superbot\\App\\Controllers\\Query\\MovieController' => __DIR__ . '/../..' . '/app/Controllers/Query/MovieController.php',
        'superbot\\App\\Controllers\\Query\\PlayerController' => __DIR__ . '/../..' . '/app/Controllers/Query/PlayerController.php',
        'superbot\\App\\Controllers\\Query\\PostController' => __DIR__ . '/../..' . '/app/Controllers/Query/PostController.php',
        'superbot\\App\\Controllers\\Query\\ProfileController' => __DIR__ . '/../..' . '/app/Controllers/Query/ProfileController.php',
        'superbot\\App\\Controllers\\Query\\SearchController' => __DIR__ . '/../..' . '/app/Controllers/Query/SearchController.php',
        'superbot\\App\\Controllers\\Query\\SettingsController' => __DIR__ . '/../..' . '/app/Controllers/Query/SettingsController.php',
        'superbot\\App\\Controllers\\Query\\SimulcastController' => __DIR__ . '/../..' . '/app/Controllers/Query/SimulcastController.php',
        'superbot\\App\\Controllers\\Query\\TopController' => __DIR__ . '/../..' . '/app/Controllers/Query/TopController.php',
        'superbot\\App\\Controllers\\UserController' => __DIR__ . '/../..' . '/app/Controllers/UserController.php',
        'superbot\\App\\Logger\\Log' => __DIR__ . '/../..' . '/app/Logger/Log.php',
        'superbot\\App\\Routing\\Route' => __DIR__ . '/../..' . '/app/Routing/Route.php',
        'superbot\\App\\Services\\BroadcastService' => __DIR__ . '/../..' . '/app/Services/BroadcastService.php',
        'superbot\\App\\Services\\CacheService' => __DIR__ . '/../..' . '/app/Services/CacheService.php',
        'superbot\\App\\Storage\\DB' => __DIR__ . '/../..' . '/app/Storage/DB.php',
        'superbot\\App\\Storage\\Entities\\Channel' => __DIR__ . '/../..' . '/app/Storage/Entities/Channel.php',
        'superbot\\App\\Storage\\Entities\\Episode' => __DIR__ . '/../..' . '/app/Storage/Entities/Episode.php',
        'superbot\\App\\Storage\\Entities\\Genre' => __DIR__ . '/../..' . '/app/Storage/Entities/Genre.php',
        'superbot\\App\\Storage\\Entities\\Group' => __DIR__ . '/../..' . '/app/Storage/Entities/Group.php',
        'superbot\\App\\Storage\\Entities\\Movie' => __DIR__ . '/../..' . '/app/Storage/Entities/Movie.php',
        'superbot\\App\\Storage\\Entities\\Search' => __DIR__ . '/../..' . '/app/Storage/Entities/Search.php',
        'superbot\\App\\Storage\\RedisController' => __DIR__ . '/../..' . '/app/Storage/RedisController.php',
        'superbot\\App\\Storage\\Repositories\\ChannelsRepository' => __DIR__ . '/../..' . '/app/Storage/Repositories/ChannelsRepository.php',
        'superbot\\App\\Storage\\Repositories\\CustomizedContentRepository' => __DIR__ . '/../..' . '/app/Storage/Repositories/CustomizedContentRepository.php',
        'superbot\\App\\Storage\\Repositories\\EpisodeRepository' => __DIR__ . '/../..' . '/app/Storage/Repositories/EpisodeRepository.php',
        'superbot\\App\\Storage\\Repositories\\GeneralRepository' => __DIR__ . '/../..' . '/app/Storage/Repositories/GeneralRepository.php',
        'superbot\\App\\Storage\\Repositories\\GenreRepository' => __DIR__ . '/../..' . '/app/Storage/Repositories/GenreRepository.php',
        'superbot\\App\\Storage\\Repositories\\MovieRepository' => __DIR__ . '/../..' . '/app/Storage/Repositories/MovieRepository.php',
        'superbot\\App\\Storage\\Repositories\\UserRepository' => __DIR__ . '/../..' . '/app/Storage/Repositories/UserRepository.php',
        'superbot\\App\\Storage\\TransferData' => __DIR__ . '/../..' . '/app/Storage/TransferData.php',
        'superbot\\Telegram\\Api' => __DIR__ . '/../..' . '/superbot/Telegram/Api.php',
        'superbot\\Telegram\\Client' => __DIR__ . '/../..' . '/superbot/Telegram/Client.php',
        'superbot\\Telegram\\Message' => __DIR__ . '/../..' . '/superbot/Telegram/Message.php',
        'superbot\\Telegram\\Query' => __DIR__ . '/../..' . '/superbot/Telegram/Query.php',
        'superbot\\Telegram\\Request' => __DIR__ . '/../..' . '/superbot/Telegram/Request.php',
        'superbot\\Telegram\\Update' => __DIR__ . '/../..' . '/superbot/Telegram/Update.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbb918eb47bd377324f4561bb425b0e5e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbb918eb47bd377324f4561bb425b0e5e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbb918eb47bd377324f4561bb425b0e5e::$classMap;

        }, null, ClassLoader::class);
    }
}
