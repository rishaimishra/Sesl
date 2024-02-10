<?php


namespace App\Http\Controllers\Api;

use App\Logic\SystemConfig;
use App\Models\Auto;
use App\Models\Product;
use App\Models\ProductCategory;
use Eav\Attribute;
use Eav\AttributeGroup;
use Eav\AttributeSet;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    /**
     * Display a listing of the Category.
     *
     */
    function getProductCategory($id = null)
    {

        $categories = ProductCategory::active()->where('parent_id', $id)->withCount('children')->orderBy(\DB::raw('sequence IS NULL, sequence'), 'asc')->paginate(30);
        $sponsorAll = SystemConfig::getOptionGroup(SystemConfig::SPONSOR_GROUP);
        $custom = collect(['sponsor' => $sponsorAll->{SystemConfig::PRODUCT_SPONSOR}]);
        if ($id) {
            $productCategory = ProductCategory::active()->where('id', $id)->first();
            $custom = $productCategory->sponsor_text ?
                collect(['sponsor' => $productCategory->sponsor_text]) :
                collect(['sponsor' => $sponsorAll->{SystemConfig::PRODUCT_SPONSOR}]);
        }
        $data = $custom->merge($categories);
        return $this->genericSuccess($data);
    }

    function getProducts($catid)
    {
        $product = Product::with('images', 'categories')->whereHas('categories', function ($q) use ($catid) {
            $q->where('product_category_id', '=', $catid);
        })->orderBy(\DB::raw('sequence IS NULL, sequence'), 'asc')->paginate(30);

        return $this->genericSuccess($product);
    }


    public function getProduct($id) {

        $auto = Product::select(['*', 'attr.*'])->findOrFail($id);

        $attributeSet = AttributeSet::find($auto->attribute_set_id);

        $attributeGroups = $attributeSet ? $attributeSet->groups()->whereHas('attributes')->with('attributes')->get() : collect([]);

        return response()->json($auto->toArray() + [
                'attribute_groups' => $attributeGroups->map(function(AttributeGroup $attributeGroup) use ($auto){
                    return [
                        'name' => $attributeGroup->name(),
                        'attributes' => $attributeGroup->attributes->map(function(Attribute $attribute) use ($auto){
                            return [
                                'label' => $attribute->frontendLabel(),
                                'code' => Str::camel($attribute->code()),
                                'val' => old($attribute->attribute_code, $auto->{$attribute->attribute_code})
                            ];
                        })
                    ];
                })
            ]);
    }
}
