<?php

namespace App\Repositories\Products;

use App\Repositories\Base\BaseRepository;

class ProductAttributeRepository extends BaseRepository
{
    /**
     * @var AttributeRepository $attributeRepository
     */
    public $attributeRepository = null;
    /**
     * @var AttributeValueRepository $attributeValueRepository
     */
    public $attributeValueRepository = null;

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\ProductAttribute::class;
    }

    /**
     * thiết lập
     * @return void
     */
    public function init()
    { }

    /**
     * join vói attribute va value
     * @return instance
     */
    public function joinAttributeValue()
    {
        return $this->join('attribute_values', 'attribute_values.id', '=', 'product_attributes.attribute_value_id');
    }
    /**
     * kiểm tra các repository
     *
     */
    public function checkRepositories()
    {
        if (!$this->attributeRepository) $this->attributeRepository = new AttributeRepository();
        if (!$this->attributeValueRepository) $this->attributeValueRepository = new AttributeValueRepository();
    }
    /**
     * set attribute repository
     * @param AttributeRepository $attributeRepository
     * @param AttributeValueRepository $attributeValueRepository
     *
     * @return ProductAttributeRepository
     */
    public function setRepositories(AttributeRepository $attributeRepository, AttributeValueRepository $attributeValueRepository): ProductAttributeRepository
    {
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;

        return $this;
    }


    /**
     * lấy ID giá trị thuộc tính mà sản phẩm có
     *
     * @param int $product_id
     * @param array $attributes
     * @param boolean $is_order_option
     * @param boolean $is_variant
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProductAttributeValues(int $product_id, array $attributes = [], $is_order_option = false, $is_variant = false)
    {

        $this->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
            ->select(
                'product_attributes.product_id',
                'product_attributes.attribute_value_id',
                'product_attributes.price',
                'attributes.price_type'
            );
        if ($is_order_option !== false) {
            $this->where('attributes.is_order_option', $is_order_option);

            if ($is_variant !== false) {
                $this->where('attributes.is_variant', $is_variant);
                $this->orderBy('attributes.price_type', 'DESC');
            } else {
                $this->orderBy('attributes.is_variant', 'DESC');
            }
        } else {
            $this->orderBy('attributes.is_order_option', 'DESC');
        }
        $args = [
            'product_attributes.product_id' => $product_id,
            'product_attributes.attribute_value_id' => (array) $attributes
        ];

        return $this->get($args);
    }




    /**
     * lấy giá của sản phẩm theo thuộc tính dự trên giá gốc
     * @param float $origin_price
     * @param int $product_id
     * @param array $attributes
     * @return float
     */
    public function getVariantPriceByOrigin($origin_price = 0, int $product_id = 0, array $attributes = [])
    {
        $price = $origin_price;
        if ($attributes) {
            $attrs = $this->getProductAttributeValues($product_id, $attributes, 1, 1);
            $change = 0;
            if (count($attrs)) {
                foreach ($attrs as $key => $attr) {
                    if ($attr->price_type) {
                        if (!$change) {
                            $price = $attr->price;
                            $change = 1;
                        }
                    } else {
                        $price += $attr->price;
                    }
                }
            }
        }
        return $price;
    }

    /**
     * lưu các giá trị thuộc tính biến thể?
     * @param int $product_id ID sản phẩm
     * @param int $category_id ID danh mục
     * @param array $attributes Các thuộc tính được gủi input
     * @param array $attributeGroup nhóm các loại thuộc tính và id
     * @param array $variants các giá trị biến thể
     * @param array $variant_price danh sách giá biến thể thông qua value_id
     * @param array $variant_values các giá trị bổ xung
     * @return array
     */
    public function saveAttributeValues($product_id, $category_id, array $attributes = [], array $attributeGroup = [], array $variants = [], array $variant_price = [], array $variant_values = [], array $default_selected = [])
    {
        $this->checkRepositories();
        // xóa thuộc tính dư thừa
        $this->deleteAttributeValueIgnoreList($product_id, array_merge($attributeGroup['use_list'], $attributeGroup['use_value']), ['attributes.is_variant' => 0]);
        // cập nhật các thuộc tính sử dụng list
        $saveData = [];
        if ($attributeGroup['attrs']) {
            // nếu có danh sách thuộc tính thì sẽ lặp qua để lấy thông tin thuộc tính
            foreach ($attributeGroup['attrs'] as $attribute) {
                // thuộc tính dược lấy ra từ danh sách trước đó
                if (!isset($attributes[$attribute->name])) {
                    // nếu ko có trong ds gửi lên sẽ xóa
                    $this->deleteAttributeValues($product_id, [$attribute->id], false, ['attributes.is_variant' => 0]);
                }
                // nếu có giá trụi gửi lên của thuộc tính hiện tại thì sẽ làm gì đó
                else {
                    $inputData = $attributes[$attribute->name] ?? null;
                    // neu thuộc nhóm thuộc tính sử dụng danh sách id value
                    if (in_array($attribute->id, $attributeGroup['use_list'])) {
                        // chuẩn bị cho query lấy ra các giá trị có mã sản phẩn như đã cho và ko nằm trong mảng id đã gửi
                        if (in_array($attribute->input_type, ['checklist', 'multiselect', 'tags'])) {
                            $inputData = is_array($inputData) ? $inputData : [];
                            $ignore = [];
                            $this->joinAttributeValue()->where('attribute_values.attribute_id', $attribute->id);
                            // lấy danh sach product attribute chỉ bao gồm các cột của bảng này với tham số product id
                            $productAttributes = $this->select('product_attributes.*')->get(compact('product_id'));

                            if (count($productAttributes)) {
                                foreach ($productAttributes as $productAttr) {
                                    // nếu value id ko nằm trong mảng gửi lên thì xóa. ngược lại sẽ thêm vào danh sách bỏ qua
                                    if (!in_array($productAttr->attribute_value_id, $inputData)) $productAttr->delete();
                                    else $ignore[] = $productAttr->attribute_value_id;
                                }
                            }

                            foreach ($inputData as $attribute_value_id) {
                                // nếu id gửi lên ko nằm trong danh sách bỏ qua thì tạo bản ghi mới
                                if (!in_array($attribute_value_id, $ignore)) $saveData[] = $this->save(compact('attribute_value_id', 'product_id'));
                            }
                        }
                        // ngược lại nếu thuộc tính nhận giá trị thông thường hoạc không dùng danh sách
                        else {
                            $valId = ['attribute_value_id' => $inputData, 'product_id' => $product_id];
                            $this->joinAttributeValue()
                                ->where('attribute_values.attribute_id', $attribute->id)
                                ->select('product_attributes.*');
                            if ($attrVal = $this->first(compact('product_id'))) {
                                $saveData[] = $this->update($attrVal->id, $valId);
                            } else {
                                $saveData[] = $this->save($valId);
                            }
                        }
                    }
                    // ngược lại nếu thuộc tính nhận giá trị thông thường hoạc không dùng danh sách
                    else {
                        $valueData = [
                            'attribute_id' => $attribute->id,
                            $attribute->value_type . '_value' => $inputData
                        ];
                        $this->joinAttributeValue()
                            ->where('attribute_values.attribute_id', $attribute->id)
                            ->select('product_attributes.*');
                        if ($attributeValue = $this->first(compact('product_id'))) {
                            $this->attributeValueRepository->update($attributeValue->attribute_value_id, $valueData);
                            $saveData[] = $attributeValue;
                        } else {
                            $av = $this->attributeValueRepository->create($valueData);
                            $saveData[] = $this->save(['attribute_value_id' => $av->id, 'product_id' => $product_id]);
                        }
                    }
                }
            }
        }
        $this->deleteAttributeValueIgnoreList($product_id, $attributeGroup['variant_list'], ['attributes.is_variant' => 1]);

        if ($attributeGroup['variants']) {
            foreach ($attributeGroup['variants'] as $variant) {
                if (!isset($variants[$variant->name])) {
                    // nếu ko có trong ds gửi lên sẽ xóa
                    $this->deleteAttributeValues($product_id, [$variant->id], false, ['attributes.is_variant' => 1]);
                } else {
                    $inputData = $variants[$variant->name] ?? null;
                    $inputData = is_array($inputData) ? $inputData : [];
                    $exists = [];
                    $this->joinAttributeValue()->where('attribute_values.attribute_id', $variant->id);
                    // lấy danh sach product attribute chỉ bao gồm các cột của bảng này với tham số product id
                    $productAttributes = $this->select('product_attributes.*')->get(compact('product_id'));
                    $variant_data = [];
                    if (count($productAttributes)) {
                        foreach ($productAttributes as $productAttr) {
                            $price = $variant_price[$productAttr->attribute_value_id] ?? 0;

                            // nếu value id ko nằm trong mảng gửi lên thì xóa. ngược lại sẽ thêm vào danh sách bỏ qua
                            if (!in_array($productAttr->attribute_value_id, $inputData)) $productAttr->delete();
                            else {
                                $exists[$productAttr->attribute_value_id] = $productAttr->id;
                            }
                        }
                    }

                    foreach ($inputData as $attribute_value_id) {
                        // nếu id gửi lên ko nằm trong danh sách bỏ qua thì tạo bản ghi mới
                        $data = compact('attribute_value_id', 'product_id');
                        $data['price'] = $variant_price[$attribute_value_id] ?? 0;
                        $data['is_default'] = isset($default_selected[$variant->id]) && $default_selected[$variant->id] == $attribute_value_id ? 1 : 0;
                        if (isset($variant_values[$attribute_value_id]) && (strlen($a = $variant_values[$attribute_value_id]) || $variant->addvance_value_type != 'image')) $data['advance_value'] = $a;
                        $id = array_key_exists($attribute_value_id, $exists) ? $exists[$attribute_value_id] : 0;
                        $saveData[] = $this->save($data, $id);
                    }
                }
            }
        }

        return $saveData;
    }

    /**
     * xóa các giá trị dược liên kết ko có trong danh sách
     * @param int $product_id
     * @param array $list
     * @param array $args
     */
    public function deleteAttributeValueIgnoreList($product_id, $list = [], array $args = [])
    {
        return $this->deleteAttributeValues($product_id, $list, true, $args);
    }
    /**
     * xóa các giá trị dược liên kết ko có trong danh sách
     * @param int $product_id
     * @param array $list
     * @param array $args
     *
     */
    public function deleteAttributeValues($product_id, $list = [], $ignore = false, array $args = [])
    {
        if ($list) {
            if ($ignore) {
                $this->whereNotIn('attribute_values.attribute_id', $list);
            } else {
                $this->whereIn('attribute_values.attribute_id', $list);
            }
        }
        $this->joinAttributeValue()
            ->where('product_attributes.product_id', $product_id)
            ->select('product_attributes.*');

        if ($args) {
            $this->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id');
        }

        if (count($values = $this->get($args))) {
            foreach ($values as $productAttribute) {
                $productAttribute->delete();
            }
        }
    }


}
