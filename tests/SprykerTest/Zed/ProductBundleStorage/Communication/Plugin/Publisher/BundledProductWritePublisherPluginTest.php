<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\ProductBundleStorage\Communication\Plugin\Publisher;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Orm\Zed\ProductBundle\Persistence\Map\SpyProductBundleTableMap;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Queue\QueueDependencyProvider;
use Spryker\Shared\ProductBundleStorage\ProductBundleStorageConfig;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundle\BundledProductWritePublisherPlugin;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductBundleStorage
 * @group Communication
 * @group Plugin
 * @group Publisher
 * @group BundledProductWritePublisherPluginTest
 * Add your own group annotations below this line
 */
class BundledProductWritePublisherPluginTest extends Unit
{
    protected const FAKE_ID_PRODUCT_CONCRETE = 6666;

    /**
     * @var \SprykerTest\Zed\ProductBundleStorage\ProductBundleStorageCommunicationTester
     */
    protected $tester;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->tester->setDependency(QueueDependencyProvider::QUEUE_ADAPTERS, function (Container $container) {
            return [
                $container->getLocator()->rabbitMq()->client()->createQueueAdapter(),
            ];
        });
    }

    /**
     * @return void
     */
    public function testBundledProductWritePublisherPlugin(): void
    {
        // Arrange
        $productConcreteTransfer = $this->tester->haveProductBundle($this->tester->haveFullProduct());
        $productForBundleTransfers = $productConcreteTransfer->getProductBundle()->getBundledProducts();

        // Act
        $bundledProductWritePublisherPlugin = new BundledProductWritePublisherPlugin();
        $eventTransfers = [
            (new EventEntityTransfer())->setForeignKeys([
                SpyProductBundleTableMap::COL_FK_PRODUCT => $productConcreteTransfer->getIdProductConcrete(),
            ]),
        ];

        $bundledProductWritePublisherPlugin->handleBulk($eventTransfers, ProductBundleStorageConfig::ENTITY_SPY_PRODUCT_BUNDLE_CREATE);

        // Assert
        $productBundleStorageTransfer = $this->tester->findProductBundleStorageByFkProduct($productConcreteTransfer->getIdProductConcrete());
        $productForBundleStorageTransfers = $productBundleStorageTransfer->getBundledProducts();

        $this->assertSame($productConcreteTransfer->getIdProductConcrete(), $productBundleStorageTransfer->getIdProductConcreteBundle());
        $this->assertSame(
            $productForBundleTransfers->offsetGet(2)->getIdProductConcrete(),
            $productForBundleStorageTransfers->offsetGet(2)->getIdProductConcrete()
        );
        $this->assertSame(
            $productForBundleTransfers->offsetGet(2)->getQuantity(),
            $productForBundleStorageTransfers->offsetGet(2)->getQuantity()
        );
        $this->assertSame(
            $productForBundleTransfers->offsetGet(1)->getIdProductConcrete(),
            $productForBundleStorageTransfers->offsetGet(1)->getIdProductConcrete()
        );
        $this->assertSame(
            $productForBundleTransfers->offsetGet(0)->getIdProductConcrete(),
            $productForBundleStorageTransfers->offsetGet(0)->getIdProductConcrete()
        );
    }

    /**
     * @return void
     */
    public function testBundledProductWritePublisherPluginWithSeveralIds(): void
    {
        // Arrange
        $firstProductConcreteTransfer = $this->tester->haveProductBundle($this->tester->haveFullProduct());
        $secondProductConcreteTransfer = $this->tester->haveProductBundle($this->tester->haveFullProduct());

        // Act
        $bundledProductWritePublisherPlugin = new BundledProductWritePublisherPlugin();
        $eventTransfers = [
            (new EventEntityTransfer())->setForeignKeys([
                SpyProductBundleTableMap::COL_FK_PRODUCT => $firstProductConcreteTransfer->getIdProductConcrete(),
            ]),
            (new EventEntityTransfer())->setForeignKeys([
                SpyProductBundleTableMap::COL_FK_PRODUCT => $secondProductConcreteTransfer->getIdProductConcrete(),
            ]),
        ];

        $bundledProductWritePublisherPlugin->handleBulk($eventTransfers, ProductBundleStorageConfig::ENTITY_SPY_PRODUCT_BUNDLE_UPDATE);

        // Assert
        $firstProductBundleStorageTransfer = $this->tester->findProductBundleStorageByFkProduct($firstProductConcreteTransfer->getIdProductConcrete());
        $secondProductBundleStorageTransfer = $this->tester->findProductBundleStorageByFkProduct($secondProductConcreteTransfer->getIdProductConcrete());

        $this->assertSame($firstProductConcreteTransfer->getIdProductConcrete(), $firstProductBundleStorageTransfer->getIdProductConcreteBundle());
        $this->assertSame($secondProductConcreteTransfer->getIdProductConcrete(), $secondProductBundleStorageTransfer->getIdProductConcreteBundle());
    }

    /**
     * @return void
     */
    public function testBundledProductWritePublisherPluginWithFakeProductConcreteId(): void
    {
        // Arrange

        // Act
        $bundledProductWritePublisherPlugin = new BundledProductWritePublisherPlugin();
        $eventTransfers = [
            (new EventEntityTransfer())->setForeignKeys([
                SpyProductBundleTableMap::COL_FK_PRODUCT => static::FAKE_ID_PRODUCT_CONCRETE,
            ]),
        ];

        $bundledProductWritePublisherPlugin->handleBulk($eventTransfers, ProductBundleStorageConfig::ENTITY_SPY_PRODUCT_BUNDLE_DELETE);

        // Assert
        $productBundleStorageTransfer = $this->tester->findProductBundleStorageByFkProduct(static::FAKE_ID_PRODUCT_CONCRETE);

        $this->assertNull($productBundleStorageTransfer);
    }
}
