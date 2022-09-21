<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductBundleStorage\Dependency\Client;

interface ProductBundleStorageToProductStorageClientInterface
{
    /**
     * @param array<int> $productConcreteIds
     * @param string $localeName
     * @param array $selectedAttributes
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    public function getProductConcreteViewTransfers(array $productConcreteIds, string $localeName, array $selectedAttributes = []): array;
}
