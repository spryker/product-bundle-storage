<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundle;

use Spryker\Shared\ProductBundleStorage\ProductBundleStorageConfig;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface;

/**
 * @method \Spryker\Zed\ProductBundleStorage\ProductBundleStorageConfig getConfig()
 * @method \Spryker\Zed\ProductBundleStorage\Business\ProductBundleStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductBundleStorage\Communication\ProductBundleStorageCommunicationFactory getFactory()
 */
class ProductConcreteProductBundleWritePublisherPlugin extends AbstractPlugin implements PublisherPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName): void
    {
        $this->getFacade()->writeCollectionByProductEvents($eventTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @phpstan-return array<int, string>
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            ProductBundleStorageConfig::ENTITY_SPY_PRODUCT_UPDATE,
        ];
    }
}