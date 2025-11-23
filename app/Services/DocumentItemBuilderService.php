<?php

namespace App\Services;

class DocumentItemBuilderService
{
    /**
     * Build items based on the type/category.
     * This method constructs an array of items with their respective details
     * such as type, category, quantity, price, total price, purpose, and message
     * based on the provided types, category, quantities, and prices.
     * It is designed to be flexible, allowing for both fixed and variable quantities
     * depending on the `isFixedQty` parameter.
     *
     * @param array $types
     * @param string $category
     * @param array $quantities
     * @param array $prices
     * @param object $request
     * @param bool $isFixedQty
     * @return array
     *
     *
     */
    public function build(array $types, string $category, array $quantities, array $prices, $request, bool $isFixedQty = false): array
    {
        $purposes = $request->input('other_purpose');
        $defaultPurpose = $request->input('purpose');

        $items = [];
        foreach ($types as $type) {
            $qty = $isFixedQty ? 1 : ($quantities[$type] ?? 1);
            $price = $prices[$type] ?? 0;
            $total = $qty * $price;

            $items[] = [
                'type'         => $type,
                'category'     => $category,
                'quantity'     => $qty,
                'price'        => $price,
                'total_price'  => $total,
                'purpose'      => $purposes ?? $defaultPurpose,
                'message'      => $request->message,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        return $items;
    }

}
