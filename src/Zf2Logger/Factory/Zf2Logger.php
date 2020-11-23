<?php
namespace EddieJaoude\Zf2Logger\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Log\Filter\Priority;
use EddieJaoude\Zf2Logger\Log\Logger;

class Zf2Logger implements FactoryInterface
{

    /**
     * @var  Logger
     */
    private $logger;

    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Create service
     * @param ServiceLocatorInterface $serviceLocator
     * @return Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this->build($serviceLocator);
    }

    public function __invoke(\Interop\Container\ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        return $this->build($container);
    }

    private function build($container)
    {
        $config = $container->get('Config');
        $config = $config['EddieJaoude\Zf2Logger'];
        $this->logger = new Logger();

        $this->configuration($config);
        $this->writerCollection($config);
        $this->execute();

        return $this->logger;
    }

    /**
     * @param array $config
     *
     * @return int
     */
    private function writerCollection(array $config)
    {
        if (!empty($config['writers'])) {
            $writers = 0;
            foreach ($config['writers'] as $writer) {
                if ($writer['enabled']) {
                    $this->writerAdapter( $writer );
                    $writers ++;
                }
            }

            return $writers;
        }
    }

    /**
     * @param array $writer
     *
     * @return \Zend\Log\Writer\AbstractWriter
     */
    private function writerAdapter(array $writer)
    {
        $writerAdapter = new $writer['adapter']($writer['options']['output']);
        $this->logger->addWriter($writerAdapter);

        $writerAdapter->addFilter(
            new Priority(
                $writer['filter']
            )
        );

        return $writerAdapter;
    }

    /**
     * @param array $config
     */
    private function configuration(array $config)
    {
        if (!empty($config['registerErrorHandler'])) {
            $config['registerErrorHandler'] === false ?: Logger::registerErrorHandler( $this->logger );
        }
        if (!empty($config['registerExceptionHandler'])) {
            $config['registerExceptionHandler'] === false ?: Logger::registerExceptionHandler( $this->logger );
        }
    }

    /**
     * @return Logger
     */
    private function execute()
    {
        if ($this->logger->getWriters()->count() == 0) {
            return $this->logger->addWriter(new  \Zend\Log\Writer\Noop);
        }
    }
}
