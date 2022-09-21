<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductBundleStorage;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ProductBundleStorage\Dependency\Client\ProductBundleStorageToProductStorageClientInterface;
use Spryker\Client\ProductBundleStorage\Dependency\Client\ProductBundleStorageToStorageClientInterface;
use Spryker\Client\ProductBundleStorage\Dependency\Service\ProductBundleStorageToSynchronizationServiceInterface;
use Spryker\Client\ProductBundleStorage\Dependency\Service\ProductBundleStorageToUtilEncodingServiceInterface;
use Spryker\Client\ProductBundleStorage\Expander\ProductViewProductBundleExpander;
use Spryker\Client\ProductBundleStorage\Expander\ProductViewProductBundleExpanderInterface;
use Spryker\Client\ProductBundleStorage\Mapper\ProductBundleStorageMapper;
use Spryker\Client\ProductBundleStorage\Mapper\ProductBundleStorageMapperInterface;
use Spryker\Client\ProductBundleStorage\Reader\ProductBundleStorageReader;
use Spryker\Client\ProductBundleStorage\Reader\ProductBundleStorageReaderInterface;

class ProductBundleStorageFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\ProductBundleStorage\Reader\ProductBundleStorageReaderInterface
     */
    public function createProductBundleStorageReader(): ProductBundleStorageReaderInterface
    {
        return new ProductBundleStorageReader(
            $this->getStorageClient(),
            $this->getSynchronizationService(),
            $this->getUtilEncodingService(),
        );
    }

    /**
     * @return \Spryker\Client\ProductBundleStorage\Expander\ProductViewProductBundleExpanderInterface
     */
    public function createProductViewProductBundleExpander(): ProductViewProductBundleExpanderInterface
    {
        return new ProductViewProductBundleExpander(
            $this->createProductBundleStorageReader(),
            $this->getProductStorageClient(),
            $this->createProductBundleStorageMapper(),
        );
    }

    /**
     * @return \Spryker\Client\ProductBundleStorage\Mapper\ProductBundleStorageMapperInterface
     */
    public function createProductBundleStorageMapper(): ProductBundleStorageMapperInterface
    {
        return new ProductBundleStorageMapper();
    }

    /**
     * @return \Spryker\Client\ProductBundleStorage\Dependency\Client\ProductBundleStorageToStorageClientInterface
     */
    public function getStorageClient(): ProductBundleStorageToStorageClientInterface
    {
        return $this->getProvidedDependency(ProductBundleStorageDependencyProvider::CLIENT_STORAGE);
    }

    /**
     * @return \Spryker\Client\ProductBundleStorage\Dependency\Service\ProductBundleStorageToSynchronizationServiceInterface
     */
    public function getSynchronizationService(): ProductBundleStorageToSynchronizationServiceInterface
    {
        return $this->getProvidedDependency(ProductBundleStorageDependencyProvider::SERVICE_SYNCHRONIZATION);
    }

    /**
     * @return \Spryker\Client\ProductBundleStorage\Dependency\Service\ProductBundleStorageToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): ProductBundleStorageToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(ProductBundleStorageDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \Spryker\Client\ProductBundleStorage\Dependency\Client\ProductBundleStorageToProductStorageClientInterface
     */
    public function getProductStorageClient(): ProductBundleStorageToProductStorageClientInterface
    {
        return $this->getProvidedDependency(ProductBundleStorageDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }
}
