<?php


namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use App\Library\Grid\Grid;
use App\Traits\AlertMessage;
use Eav\AttributeGroup;
use Eav\AttributeSet;
use Eav\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AttributeGroupController extends Controller
{
    use AlertMessage;

    public $module = "Attribute Group";

    public function index(Request $request)
    {
        $attributeGroup = AttributeGroup::select('attribute_groups.*', 'attribute_sets.attribute_set_name')->join('attribute_sets', 'attribute_sets.attribute_set_id', 'attribute_groups.attribute_set_id');

        $grid = (new Grid())
            ->setQuery($attributeGroup)
            ->setColumns([
                [
                    'field' => 'attribute_group_name',
                    'label' => 'Name',
                    'sortable' => true,
                    'filterable' => true
                ],
                [
                    'field' => 'attribute_set_name',
                    'label' => 'Attribute Set',
                    'sortable' => true,
                    'filterable' => true
                ]
            ])->setButtons([
                [
                    'label' => 'Edit',
                    'icon' => 'edit',
                    'url' => function ($item) {
                        return route('admin.attribute-group.edit', $item->attribute_group_id);
                    }
                ]
            ])->generate();

        return view('admin.attribute.attribute-group.grid', compact('grid'));
    }

    public function create()
    {
        $attributeSets = AttributeSet::pluck('attribute_set_name', 'attribute_set_id');

        return view('admin.attribute.attribute-group.create')->with(compact('attributeSets'));
    }

    public function store(Request $request)
    {
        $this->validator()->validate();

        $attributeGroup = AttributeGroup::create($request->all());

        return redirect()->route('admin.attribute-group.edit', ['attribute_group' => $attributeGroup->attribute_group_id])->with($this->createResponse());
    }

    public function edit(AttributeGroup $attributeGroup, Request $request)
    {
        $attributeSets = AttributeSet::pluck('attribute_set_name', 'attribute_set_id');

        return view('admin.attribute.attribute-group.edit')
            ->with(compact('attributeSets', 'attributeGroup'));
    }

    public function update(AttributeGroup $attributeGroup, Request $request)
    {
        $this->validator()->validate();

        $attributeGroup->fill($request->all())->save();

        return redirect()->back()->with($this->updateResponse());
    }

    public function destroy(AttributeGroup $attributeGroup, Request $request)
    {
        $attributeGroup->delete();

        return redirect()->route('admin.attribute-group.index', ['attribute_group' => $attributeGroup->attribute_group_id])->with($this->deleteResponse());
    }

    protected function validator()
    {
        $attributeGroupId = \request()->route('attribute_group') ? \request()->route('attribute_group')->attribute_group_id : null;

        return Validator::make(\request()->all(), [
            'attribute_group_name' => ['required', 'string', 'max:100', Rule::unique('attribute_groups', 'attribute_group_name')
                ->where('attribute_set_id', \request('attribute_set_id'))
                ->ignore(
                $attributeGroupId,
                'attribute_group_id'
            )],
            'attribute_set_id' => ['required'],
            'sequence' => ['required', 'integer']
        ]);
    }
}
