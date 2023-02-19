<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'DI\\Annotation\\Inject' => $vendorDir . '/php-di/php-di/src/Annotation/Inject.php',
    'DI\\Annotation\\Injectable' => $vendorDir . '/php-di/php-di/src/Annotation/Injectable.php',
    'DI\\CompiledContainer' => $vendorDir . '/php-di/php-di/src/CompiledContainer.php',
    'DI\\Compiler\\Compiler' => $vendorDir . '/php-di/php-di/src/Compiler/Compiler.php',
    'DI\\Compiler\\ObjectCreationCompiler' => $vendorDir . '/php-di/php-di/src/Compiler/ObjectCreationCompiler.php',
    'DI\\Compiler\\RequestedEntryHolder' => $vendorDir . '/php-di/php-di/src/Compiler/RequestedEntryHolder.php',
    'DI\\Container' => $vendorDir . '/php-di/php-di/src/Container.php',
    'DI\\ContainerBuilder' => $vendorDir . '/php-di/php-di/src/ContainerBuilder.php',
    'DI\\Definition\\ArrayDefinition' => $vendorDir . '/php-di/php-di/src/Definition/ArrayDefinition.php',
    'DI\\Definition\\ArrayDefinitionExtension' => $vendorDir . '/php-di/php-di/src/Definition/ArrayDefinitionExtension.php',
    'DI\\Definition\\AutowireDefinition' => $vendorDir . '/php-di/php-di/src/Definition/AutowireDefinition.php',
    'DI\\Definition\\DecoratorDefinition' => $vendorDir . '/php-di/php-di/src/Definition/DecoratorDefinition.php',
    'DI\\Definition\\Definition' => $vendorDir . '/php-di/php-di/src/Definition/Definition.php',
    'DI\\Definition\\Dumper\\ObjectDefinitionDumper' => $vendorDir . '/php-di/php-di/src/Definition/Dumper/ObjectDefinitionDumper.php',
    'DI\\Definition\\EnvironmentVariableDefinition' => $vendorDir . '/php-di/php-di/src/Definition/EnvironmentVariableDefinition.php',
    'DI\\Definition\\Exception\\InvalidAnnotation' => $vendorDir . '/php-di/php-di/src/Definition/Exception/InvalidAnnotation.php',
    'DI\\Definition\\Exception\\InvalidDefinition' => $vendorDir . '/php-di/php-di/src/Definition/Exception/InvalidDefinition.php',
    'DI\\Definition\\ExtendsPreviousDefinition' => $vendorDir . '/php-di/php-di/src/Definition/ExtendsPreviousDefinition.php',
    'DI\\Definition\\FactoryDefinition' => $vendorDir . '/php-di/php-di/src/Definition/FactoryDefinition.php',
    'DI\\Definition\\Helper\\AutowireDefinitionHelper' => $vendorDir . '/php-di/php-di/src/Definition/Helper/AutowireDefinitionHelper.php',
    'DI\\Definition\\Helper\\CreateDefinitionHelper' => $vendorDir . '/php-di/php-di/src/Definition/Helper/CreateDefinitionHelper.php',
    'DI\\Definition\\Helper\\DefinitionHelper' => $vendorDir . '/php-di/php-di/src/Definition/Helper/DefinitionHelper.php',
    'DI\\Definition\\Helper\\FactoryDefinitionHelper' => $vendorDir . '/php-di/php-di/src/Definition/Helper/FactoryDefinitionHelper.php',
    'DI\\Definition\\InstanceDefinition' => $vendorDir . '/php-di/php-di/src/Definition/InstanceDefinition.php',
    'DI\\Definition\\ObjectDefinition' => $vendorDir . '/php-di/php-di/src/Definition/ObjectDefinition.php',
    'DI\\Definition\\ObjectDefinition\\MethodInjection' => $vendorDir . '/php-di/php-di/src/Definition/ObjectDefinition/MethodInjection.php',
    'DI\\Definition\\ObjectDefinition\\PropertyInjection' => $vendorDir . '/php-di/php-di/src/Definition/ObjectDefinition/PropertyInjection.php',
    'DI\\Definition\\Reference' => $vendorDir . '/php-di/php-di/src/Definition/Reference.php',
    'DI\\Definition\\Resolver\\ArrayResolver' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/ArrayResolver.php',
    'DI\\Definition\\Resolver\\DecoratorResolver' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/DecoratorResolver.php',
    'DI\\Definition\\Resolver\\DefinitionResolver' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/DefinitionResolver.php',
    'DI\\Definition\\Resolver\\EnvironmentVariableResolver' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/EnvironmentVariableResolver.php',
    'DI\\Definition\\Resolver\\FactoryResolver' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/FactoryResolver.php',
    'DI\\Definition\\Resolver\\InstanceInjector' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/InstanceInjector.php',
    'DI\\Definition\\Resolver\\ObjectCreator' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/ObjectCreator.php',
    'DI\\Definition\\Resolver\\ParameterResolver' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/ParameterResolver.php',
    'DI\\Definition\\Resolver\\ResolverDispatcher' => $vendorDir . '/php-di/php-di/src/Definition/Resolver/ResolverDispatcher.php',
    'DI\\Definition\\SelfResolvingDefinition' => $vendorDir . '/php-di/php-di/src/Definition/SelfResolvingDefinition.php',
    'DI\\Definition\\Source\\AnnotationBasedAutowiring' => $vendorDir . '/php-di/php-di/src/Definition/Source/AnnotationBasedAutowiring.php',
    'DI\\Definition\\Source\\Autowiring' => $vendorDir . '/php-di/php-di/src/Definition/Source/Autowiring.php',
    'DI\\Definition\\Source\\DefinitionArray' => $vendorDir . '/php-di/php-di/src/Definition/Source/DefinitionArray.php',
    'DI\\Definition\\Source\\DefinitionFile' => $vendorDir . '/php-di/php-di/src/Definition/Source/DefinitionFile.php',
    'DI\\Definition\\Source\\DefinitionNormalizer' => $vendorDir . '/php-di/php-di/src/Definition/Source/DefinitionNormalizer.php',
    'DI\\Definition\\Source\\DefinitionSource' => $vendorDir . '/php-di/php-di/src/Definition/Source/DefinitionSource.php',
    'DI\\Definition\\Source\\MutableDefinitionSource' => $vendorDir . '/php-di/php-di/src/Definition/Source/MutableDefinitionSource.php',
    'DI\\Definition\\Source\\NoAutowiring' => $vendorDir . '/php-di/php-di/src/Definition/Source/NoAutowiring.php',
    'DI\\Definition\\Source\\ReflectionBasedAutowiring' => $vendorDir . '/php-di/php-di/src/Definition/Source/ReflectionBasedAutowiring.php',
    'DI\\Definition\\Source\\SourceCache' => $vendorDir . '/php-di/php-di/src/Definition/Source/SourceCache.php',
    'DI\\Definition\\Source\\SourceChain' => $vendorDir . '/php-di/php-di/src/Definition/Source/SourceChain.php',
    'DI\\Definition\\StringDefinition' => $vendorDir . '/php-di/php-di/src/Definition/StringDefinition.php',
    'DI\\Definition\\ValueDefinition' => $vendorDir . '/php-di/php-di/src/Definition/ValueDefinition.php',
    'DI\\DependencyException' => $vendorDir . '/php-di/php-di/src/DependencyException.php',
    'DI\\FactoryInterface' => $vendorDir . '/php-di/php-di/src/FactoryInterface.php',
    'DI\\Factory\\RequestedEntry' => $vendorDir . '/php-di/php-di/src/Factory/RequestedEntry.php',
    'DI\\Invoker\\DefinitionParameterResolver' => $vendorDir . '/php-di/php-di/src/Invoker/DefinitionParameterResolver.php',
    'DI\\Invoker\\FactoryParameterResolver' => $vendorDir . '/php-di/php-di/src/Invoker/FactoryParameterResolver.php',
    'DI\\NotFoundException' => $vendorDir . '/php-di/php-di/src/NotFoundException.php',
    'DI\\Proxy\\ProxyFactory' => $vendorDir . '/php-di/php-di/src/Proxy/ProxyFactory.php',
    'GuzzleHttp\\BodySummarizer' => $vendorDir . '/guzzlehttp/guzzle/src/BodySummarizer.php',
    'GuzzleHttp\\BodySummarizerInterface' => $vendorDir . '/guzzlehttp/guzzle/src/BodySummarizerInterface.php',
    'GuzzleHttp\\Client' => $vendorDir . '/guzzlehttp/guzzle/src/Client.php',
    'GuzzleHttp\\ClientInterface' => $vendorDir . '/guzzlehttp/guzzle/src/ClientInterface.php',
    'GuzzleHttp\\ClientTrait' => $vendorDir . '/guzzlehttp/guzzle/src/ClientTrait.php',
    'GuzzleHttp\\Cookie\\CookieJar' => $vendorDir . '/guzzlehttp/guzzle/src/Cookie/CookieJar.php',
    'GuzzleHttp\\Cookie\\CookieJarInterface' => $vendorDir . '/guzzlehttp/guzzle/src/Cookie/CookieJarInterface.php',
    'GuzzleHttp\\Cookie\\FileCookieJar' => $vendorDir . '/guzzlehttp/guzzle/src/Cookie/FileCookieJar.php',
    'GuzzleHttp\\Cookie\\SessionCookieJar' => $vendorDir . '/guzzlehttp/guzzle/src/Cookie/SessionCookieJar.php',
    'GuzzleHttp\\Cookie\\SetCookie' => $vendorDir . '/guzzlehttp/guzzle/src/Cookie/SetCookie.php',
    'GuzzleHttp\\Exception\\BadResponseException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/BadResponseException.php',
    'GuzzleHttp\\Exception\\ClientException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/ClientException.php',
    'GuzzleHttp\\Exception\\ConnectException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/ConnectException.php',
    'GuzzleHttp\\Exception\\GuzzleException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/GuzzleException.php',
    'GuzzleHttp\\Exception\\InvalidArgumentException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/InvalidArgumentException.php',
    'GuzzleHttp\\Exception\\RequestException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/RequestException.php',
    'GuzzleHttp\\Exception\\ServerException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/ServerException.php',
    'GuzzleHttp\\Exception\\TooManyRedirectsException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/TooManyRedirectsException.php',
    'GuzzleHttp\\Exception\\TransferException' => $vendorDir . '/guzzlehttp/guzzle/src/Exception/TransferException.php',
    'GuzzleHttp\\HandlerStack' => $vendorDir . '/guzzlehttp/guzzle/src/HandlerStack.php',
    'GuzzleHttp\\Handler\\CurlFactory' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/CurlFactory.php',
    'GuzzleHttp\\Handler\\CurlFactoryInterface' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/CurlFactoryInterface.php',
    'GuzzleHttp\\Handler\\CurlHandler' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/CurlHandler.php',
    'GuzzleHttp\\Handler\\CurlMultiHandler' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/CurlMultiHandler.php',
    'GuzzleHttp\\Handler\\EasyHandle' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/EasyHandle.php',
    'GuzzleHttp\\Handler\\HeaderProcessor' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/HeaderProcessor.php',
    'GuzzleHttp\\Handler\\MockHandler' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/MockHandler.php',
    'GuzzleHttp\\Handler\\Proxy' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/Proxy.php',
    'GuzzleHttp\\Handler\\StreamHandler' => $vendorDir . '/guzzlehttp/guzzle/src/Handler/StreamHandler.php',
    'GuzzleHttp\\MessageFormatter' => $vendorDir . '/guzzlehttp/guzzle/src/MessageFormatter.php',
    'GuzzleHttp\\MessageFormatterInterface' => $vendorDir . '/guzzlehttp/guzzle/src/MessageFormatterInterface.php',
    'GuzzleHttp\\Middleware' => $vendorDir . '/guzzlehttp/guzzle/src/Middleware.php',
    'GuzzleHttp\\Pool' => $vendorDir . '/guzzlehttp/guzzle/src/Pool.php',
    'GuzzleHttp\\PrepareBodyMiddleware' => $vendorDir . '/guzzlehttp/guzzle/src/PrepareBodyMiddleware.php',
    'GuzzleHttp\\Promise\\AggregateException' => $vendorDir . '/guzzlehttp/promises/src/AggregateException.php',
    'GuzzleHttp\\Promise\\CancellationException' => $vendorDir . '/guzzlehttp/promises/src/CancellationException.php',
    'GuzzleHttp\\Promise\\Coroutine' => $vendorDir . '/guzzlehttp/promises/src/Coroutine.php',
    'GuzzleHttp\\Promise\\Create' => $vendorDir . '/guzzlehttp/promises/src/Create.php',
    'GuzzleHttp\\Promise\\Each' => $vendorDir . '/guzzlehttp/promises/src/Each.php',
    'GuzzleHttp\\Promise\\EachPromise' => $vendorDir . '/guzzlehttp/promises/src/EachPromise.php',
    'GuzzleHttp\\Promise\\FulfilledPromise' => $vendorDir . '/guzzlehttp/promises/src/FulfilledPromise.php',
    'GuzzleHttp\\Promise\\Is' => $vendorDir . '/guzzlehttp/promises/src/Is.php',
    'GuzzleHttp\\Promise\\Promise' => $vendorDir . '/guzzlehttp/promises/src/Promise.php',
    'GuzzleHttp\\Promise\\PromiseInterface' => $vendorDir . '/guzzlehttp/promises/src/PromiseInterface.php',
    'GuzzleHttp\\Promise\\PromisorInterface' => $vendorDir . '/guzzlehttp/promises/src/PromisorInterface.php',
    'GuzzleHttp\\Promise\\RejectedPromise' => $vendorDir . '/guzzlehttp/promises/src/RejectedPromise.php',
    'GuzzleHttp\\Promise\\RejectionException' => $vendorDir . '/guzzlehttp/promises/src/RejectionException.php',
    'GuzzleHttp\\Promise\\TaskQueue' => $vendorDir . '/guzzlehttp/promises/src/TaskQueue.php',
    'GuzzleHttp\\Promise\\TaskQueueInterface' => $vendorDir . '/guzzlehttp/promises/src/TaskQueueInterface.php',
    'GuzzleHttp\\Promise\\Utils' => $vendorDir . '/guzzlehttp/promises/src/Utils.php',
    'GuzzleHttp\\Psr7\\AppendStream' => $vendorDir . '/guzzlehttp/psr7/src/AppendStream.php',
    'GuzzleHttp\\Psr7\\BufferStream' => $vendorDir . '/guzzlehttp/psr7/src/BufferStream.php',
    'GuzzleHttp\\Psr7\\CachingStream' => $vendorDir . '/guzzlehttp/psr7/src/CachingStream.php',
    'GuzzleHttp\\Psr7\\DroppingStream' => $vendorDir . '/guzzlehttp/psr7/src/DroppingStream.php',
    'GuzzleHttp\\Psr7\\Exception\\MalformedUriException' => $vendorDir . '/guzzlehttp/psr7/src/Exception/MalformedUriException.php',
    'GuzzleHttp\\Psr7\\FnStream' => $vendorDir . '/guzzlehttp/psr7/src/FnStream.php',
    'GuzzleHttp\\Psr7\\Header' => $vendorDir . '/guzzlehttp/psr7/src/Header.php',
    'GuzzleHttp\\Psr7\\HttpFactory' => $vendorDir . '/guzzlehttp/psr7/src/HttpFactory.php',
    'GuzzleHttp\\Psr7\\InflateStream' => $vendorDir . '/guzzlehttp/psr7/src/InflateStream.php',
    'GuzzleHttp\\Psr7\\LazyOpenStream' => $vendorDir . '/guzzlehttp/psr7/src/LazyOpenStream.php',
    'GuzzleHttp\\Psr7\\LimitStream' => $vendorDir . '/guzzlehttp/psr7/src/LimitStream.php',
    'GuzzleHttp\\Psr7\\Message' => $vendorDir . '/guzzlehttp/psr7/src/Message.php',
    'GuzzleHttp\\Psr7\\MessageTrait' => $vendorDir . '/guzzlehttp/psr7/src/MessageTrait.php',
    'GuzzleHttp\\Psr7\\MimeType' => $vendorDir . '/guzzlehttp/psr7/src/MimeType.php',
    'GuzzleHttp\\Psr7\\MultipartStream' => $vendorDir . '/guzzlehttp/psr7/src/MultipartStream.php',
    'GuzzleHttp\\Psr7\\NoSeekStream' => $vendorDir . '/guzzlehttp/psr7/src/NoSeekStream.php',
    'GuzzleHttp\\Psr7\\PumpStream' => $vendorDir . '/guzzlehttp/psr7/src/PumpStream.php',
    'GuzzleHttp\\Psr7\\Query' => $vendorDir . '/guzzlehttp/psr7/src/Query.php',
    'GuzzleHttp\\Psr7\\Request' => $vendorDir . '/guzzlehttp/psr7/src/Request.php',
    'GuzzleHttp\\Psr7\\Response' => $vendorDir . '/guzzlehttp/psr7/src/Response.php',
    'GuzzleHttp\\Psr7\\Rfc7230' => $vendorDir . '/guzzlehttp/psr7/src/Rfc7230.php',
    'GuzzleHttp\\Psr7\\ServerRequest' => $vendorDir . '/guzzlehttp/psr7/src/ServerRequest.php',
    'GuzzleHttp\\Psr7\\Stream' => $vendorDir . '/guzzlehttp/psr7/src/Stream.php',
    'GuzzleHttp\\Psr7\\StreamDecoratorTrait' => $vendorDir . '/guzzlehttp/psr7/src/StreamDecoratorTrait.php',
    'GuzzleHttp\\Psr7\\StreamWrapper' => $vendorDir . '/guzzlehttp/psr7/src/StreamWrapper.php',
    'GuzzleHttp\\Psr7\\UploadedFile' => $vendorDir . '/guzzlehttp/psr7/src/UploadedFile.php',
    'GuzzleHttp\\Psr7\\Uri' => $vendorDir . '/guzzlehttp/psr7/src/Uri.php',
    'GuzzleHttp\\Psr7\\UriComparator' => $vendorDir . '/guzzlehttp/psr7/src/UriComparator.php',
    'GuzzleHttp\\Psr7\\UriNormalizer' => $vendorDir . '/guzzlehttp/psr7/src/UriNormalizer.php',
    'GuzzleHttp\\Psr7\\UriResolver' => $vendorDir . '/guzzlehttp/psr7/src/UriResolver.php',
    'GuzzleHttp\\Psr7\\Utils' => $vendorDir . '/guzzlehttp/psr7/src/Utils.php',
    'GuzzleHttp\\RedirectMiddleware' => $vendorDir . '/guzzlehttp/guzzle/src/RedirectMiddleware.php',
    'GuzzleHttp\\RequestOptions' => $vendorDir . '/guzzlehttp/guzzle/src/RequestOptions.php',
    'GuzzleHttp\\RetryMiddleware' => $vendorDir . '/guzzlehttp/guzzle/src/RetryMiddleware.php',
    'GuzzleHttp\\TransferStats' => $vendorDir . '/guzzlehttp/guzzle/src/TransferStats.php',
    'GuzzleHttp\\Utils' => $vendorDir . '/guzzlehttp/guzzle/src/Utils.php',
    'Invoker\\CallableResolver' => $vendorDir . '/php-di/invoker/src/CallableResolver.php',
    'Invoker\\Exception\\InvocationException' => $vendorDir . '/php-di/invoker/src/Exception/InvocationException.php',
    'Invoker\\Exception\\NotCallableException' => $vendorDir . '/php-di/invoker/src/Exception/NotCallableException.php',
    'Invoker\\Exception\\NotEnoughParametersException' => $vendorDir . '/php-di/invoker/src/Exception/NotEnoughParametersException.php',
    'Invoker\\Invoker' => $vendorDir . '/php-di/invoker/src/Invoker.php',
    'Invoker\\InvokerInterface' => $vendorDir . '/php-di/invoker/src/InvokerInterface.php',
    'Invoker\\ParameterResolver\\AssociativeArrayResolver' => $vendorDir . '/php-di/invoker/src/ParameterResolver/AssociativeArrayResolver.php',
    'Invoker\\ParameterResolver\\Container\\ParameterNameContainerResolver' => $vendorDir . '/php-di/invoker/src/ParameterResolver/Container/ParameterNameContainerResolver.php',
    'Invoker\\ParameterResolver\\Container\\TypeHintContainerResolver' => $vendorDir . '/php-di/invoker/src/ParameterResolver/Container/TypeHintContainerResolver.php',
    'Invoker\\ParameterResolver\\DefaultValueResolver' => $vendorDir . '/php-di/invoker/src/ParameterResolver/DefaultValueResolver.php',
    'Invoker\\ParameterResolver\\NumericArrayResolver' => $vendorDir . '/php-di/invoker/src/ParameterResolver/NumericArrayResolver.php',
    'Invoker\\ParameterResolver\\ParameterResolver' => $vendorDir . '/php-di/invoker/src/ParameterResolver/ParameterResolver.php',
    'Invoker\\ParameterResolver\\ResolverChain' => $vendorDir . '/php-di/invoker/src/ParameterResolver/ResolverChain.php',
    'Invoker\\ParameterResolver\\TypeHintResolver' => $vendorDir . '/php-di/invoker/src/ParameterResolver/TypeHintResolver.php',
    'Invoker\\Reflection\\CallableReflection' => $vendorDir . '/php-di/invoker/src/Reflection/CallableReflection.php',
    'Laravel\\SerializableClosure\\Contracts\\Serializable' => $vendorDir . '/laravel/serializable-closure/src/Contracts/Serializable.php',
    'Laravel\\SerializableClosure\\Contracts\\Signer' => $vendorDir . '/laravel/serializable-closure/src/Contracts/Signer.php',
    'Laravel\\SerializableClosure\\Exceptions\\InvalidSignatureException' => $vendorDir . '/laravel/serializable-closure/src/Exceptions/InvalidSignatureException.php',
    'Laravel\\SerializableClosure\\Exceptions\\MissingSecretKeyException' => $vendorDir . '/laravel/serializable-closure/src/Exceptions/MissingSecretKeyException.php',
    'Laravel\\SerializableClosure\\Exceptions\\PhpVersionNotSupportedException' => $vendorDir . '/laravel/serializable-closure/src/Exceptions/PhpVersionNotSupportedException.php',
    'Laravel\\SerializableClosure\\SerializableClosure' => $vendorDir . '/laravel/serializable-closure/src/SerializableClosure.php',
    'Laravel\\SerializableClosure\\Serializers\\Native' => $vendorDir . '/laravel/serializable-closure/src/Serializers/Native.php',
    'Laravel\\SerializableClosure\\Serializers\\Signed' => $vendorDir . '/laravel/serializable-closure/src/Serializers/Signed.php',
    'Laravel\\SerializableClosure\\Signers\\Hmac' => $vendorDir . '/laravel/serializable-closure/src/Signers/Hmac.php',
    'Laravel\\SerializableClosure\\Support\\ClosureScope' => $vendorDir . '/laravel/serializable-closure/src/Support/ClosureScope.php',
    'Laravel\\SerializableClosure\\Support\\ClosureStream' => $vendorDir . '/laravel/serializable-closure/src/Support/ClosureStream.php',
    'Laravel\\SerializableClosure\\Support\\ReflectionClosure' => $vendorDir . '/laravel/serializable-closure/src/Support/ReflectionClosure.php',
    'Laravel\\SerializableClosure\\Support\\SelfReference' => $vendorDir . '/laravel/serializable-closure/src/Support/SelfReference.php',
    'Laravel\\SerializableClosure\\UnsignedSerializableClosure' => $vendorDir . '/laravel/serializable-closure/src/UnsignedSerializableClosure.php',
    'PhpDocReader\\AnnotationException' => $vendorDir . '/php-di/phpdoc-reader/src/PhpDocReader/AnnotationException.php',
    'PhpDocReader\\PhpDocReader' => $vendorDir . '/php-di/phpdoc-reader/src/PhpDocReader/PhpDocReader.php',
    'PhpDocReader\\PhpParser\\TokenParser' => $vendorDir . '/php-di/phpdoc-reader/src/PhpDocReader/PhpParser/TokenParser.php',
    'PhpDocReader\\PhpParser\\UseStatementParser' => $vendorDir . '/php-di/phpdoc-reader/src/PhpDocReader/PhpParser/UseStatementParser.php',
    'Psr\\Container\\ContainerExceptionInterface' => $vendorDir . '/psr/container/src/ContainerExceptionInterface.php',
    'Psr\\Container\\ContainerInterface' => $vendorDir . '/psr/container/src/ContainerInterface.php',
    'Psr\\Container\\NotFoundExceptionInterface' => $vendorDir . '/psr/container/src/NotFoundExceptionInterface.php',
    'Psr\\Http\\Client\\ClientExceptionInterface' => $vendorDir . '/psr/http-client/src/ClientExceptionInterface.php',
    'Psr\\Http\\Client\\ClientInterface' => $vendorDir . '/psr/http-client/src/ClientInterface.php',
    'Psr\\Http\\Client\\NetworkExceptionInterface' => $vendorDir . '/psr/http-client/src/NetworkExceptionInterface.php',
    'Psr\\Http\\Client\\RequestExceptionInterface' => $vendorDir . '/psr/http-client/src/RequestExceptionInterface.php',
    'Psr\\Http\\Message\\MessageInterface' => $vendorDir . '/psr/http-message/src/MessageInterface.php',
    'Psr\\Http\\Message\\RequestFactoryInterface' => $vendorDir . '/psr/http-factory/src/RequestFactoryInterface.php',
    'Psr\\Http\\Message\\RequestInterface' => $vendorDir . '/psr/http-message/src/RequestInterface.php',
    'Psr\\Http\\Message\\ResponseFactoryInterface' => $vendorDir . '/psr/http-factory/src/ResponseFactoryInterface.php',
    'Psr\\Http\\Message\\ResponseInterface' => $vendorDir . '/psr/http-message/src/ResponseInterface.php',
    'Psr\\Http\\Message\\ServerRequestFactoryInterface' => $vendorDir . '/psr/http-factory/src/ServerRequestFactoryInterface.php',
    'Psr\\Http\\Message\\ServerRequestInterface' => $vendorDir . '/psr/http-message/src/ServerRequestInterface.php',
    'Psr\\Http\\Message\\StreamFactoryInterface' => $vendorDir . '/psr/http-factory/src/StreamFactoryInterface.php',
    'Psr\\Http\\Message\\StreamInterface' => $vendorDir . '/psr/http-message/src/StreamInterface.php',
    'Psr\\Http\\Message\\UploadedFileFactoryInterface' => $vendorDir . '/psr/http-factory/src/UploadedFileFactoryInterface.php',
    'Psr\\Http\\Message\\UploadedFileInterface' => $vendorDir . '/psr/http-message/src/UploadedFileInterface.php',
    'Psr\\Http\\Message\\UriFactoryInterface' => $vendorDir . '/psr/http-factory/src/UriFactoryInterface.php',
    'Psr\\Http\\Message\\UriInterface' => $vendorDir . '/psr/http-message/src/UriInterface.php',
    'superbot\\App\\Configs\\DBConfigs' => $baseDir . '/app/Configs/DBConfigs.php',
    'superbot\\App\\Configs\\GeneralConfigs' => $baseDir . '/app/Configs/GeneralConfigs.php',
    'superbot\\App\\Controllers\\Controller' => $baseDir . '/app/Controllers/Controller.php',
    'superbot\\App\\Controllers\\MessageController' => $baseDir . '/app/Controllers/MessageController.php',
    'superbot\\App\\Controllers\\Messages\\CommandController' => $baseDir . '/app/Controllers/Messages/CommandController.php',
    'superbot\\App\\Controllers\\Messages\\HomeController' => $baseDir . '/app/Controllers/Messages/HomeController.php',
    'superbot\\App\\Controllers\\Messages\\PostController' => $baseDir . '/app/Controllers/Messages/PostController.php',
    'superbot\\App\\Controllers\\Messages\\SearchController' => $baseDir . '/app/Controllers/Messages/SearchController.php',
    'superbot\\App\\Controllers\\Messages\\SettingsController' => $baseDir . '/app/Controllers/Messages/SettingsController.php',
    'superbot\\App\\Controllers\\QueryController' => $baseDir . '/app/Controllers/QueryController.php',
    'superbot\\App\\Controllers\\Query\\BookmarkController' => $baseDir . '/app/Controllers/Query/BookmarkController.php',
    'superbot\\App\\Controllers\\Query\\HomeController' => $baseDir . '/app/Controllers/Query/HomeController.php',
    'superbot\\App\\Controllers\\Query\\LeadershipController' => $baseDir . '/app/Controllers/Query/LeadershipController.php',
    'superbot\\App\\Controllers\\Query\\MovieController' => $baseDir . '/app/Controllers/Query/MovieController.php',
    'superbot\\App\\Controllers\\Query\\PlayerController' => $baseDir . '/app/Controllers/Query/PlayerController.php',
    'superbot\\App\\Controllers\\Query\\PostController' => $baseDir . '/app/Controllers/Query/PostController.php',
    'superbot\\App\\Controllers\\Query\\ProfileController' => $baseDir . '/app/Controllers/Query/ProfileController.php',
    'superbot\\App\\Controllers\\Query\\SearchController' => $baseDir . '/app/Controllers/Query/SearchController.php',
    'superbot\\App\\Controllers\\Query\\SettingsController' => $baseDir . '/app/Controllers/Query/SettingsController.php',
    'superbot\\App\\Controllers\\Query\\SimulcastController' => $baseDir . '/app/Controllers/Query/SimulcastController.php',
    'superbot\\App\\Controllers\\Query\\TopController' => $baseDir . '/app/Controllers/Query/TopController.php',
    'superbot\\App\\Controllers\\UserController' => $baseDir . '/app/Controllers/UserController.php',
    'superbot\\App\\Logger\\Log' => $baseDir . '/app/Logger/Log.php',
    'superbot\\App\\Routing\\Route' => $baseDir . '/app/Routing/Route.php',
    'superbot\\App\\Services\\BroadcastService' => $baseDir . '/app/Services/BroadcastService.php',
    'superbot\\App\\Services\\CacheService' => $baseDir . '/app/Services/CacheService.php',
    'superbot\\App\\Storage\\DB' => $baseDir . '/app/Storage/DB.php',
    'superbot\\App\\Storage\\Entities\\Channel' => $baseDir . '/app/Storage/Entities/Channel.php',
    'superbot\\App\\Storage\\Entities\\Episode' => $baseDir . '/app/Storage/Entities/Episode.php',
    'superbot\\App\\Storage\\Entities\\Genre' => $baseDir . '/app/Storage/Entities/Genre.php',
    'superbot\\App\\Storage\\Entities\\Group' => $baseDir . '/app/Storage/Entities/Group.php',
    'superbot\\App\\Storage\\Entities\\Movie' => $baseDir . '/app/Storage/Entities/Movie.php',
    'superbot\\App\\Storage\\Entities\\Search' => $baseDir . '/app/Storage/Entities/Search.php',
    'superbot\\App\\Storage\\RedisController' => $baseDir . '/app/Storage/RedisController.php',
    'superbot\\App\\Storage\\Repositories\\ChannelsRepository' => $baseDir . '/app/Storage/Repositories/ChannelsRepository.php',
    'superbot\\App\\Storage\\Repositories\\CustomizedContentRepository' => $baseDir . '/app/Storage/Repositories/CustomizedContentRepository.php',
    'superbot\\App\\Storage\\Repositories\\EpisodeRepository' => $baseDir . '/app/Storage/Repositories/EpisodeRepository.php',
    'superbot\\App\\Storage\\Repositories\\GeneralRepository' => $baseDir . '/app/Storage/Repositories/GeneralRepository.php',
    'superbot\\App\\Storage\\Repositories\\GenreRepository' => $baseDir . '/app/Storage/Repositories/GenreRepository.php',
    'superbot\\App\\Storage\\Repositories\\MovieRepository' => $baseDir . '/app/Storage/Repositories/MovieRepository.php',
    'superbot\\App\\Storage\\Repositories\\UserRepository' => $baseDir . '/app/Storage/Repositories/UserRepository.php',
    'superbot\\App\\Storage\\TransferData' => $baseDir . '/app/Storage/TransferData.php',
    'superbot\\Telegram\\Api' => $baseDir . '/superbot/Telegram/Api.php',
    'superbot\\Telegram\\Client' => $baseDir . '/superbot/Telegram/Client.php',
    'superbot\\Telegram\\Message' => $baseDir . '/superbot/Telegram/Message.php',
    'superbot\\Telegram\\Query' => $baseDir . '/superbot/Telegram/Query.php',
    'superbot\\Telegram\\Request' => $baseDir . '/superbot/Telegram/Request.php',
    'superbot\\Telegram\\Update' => $baseDir . '/superbot/Telegram/Update.php',
);
