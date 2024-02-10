<?php


namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use App\Library\Grid\Grid;
use App\Traits\AlertMessage;
use Eav\AttributeSet;
use Eav\Entity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AttributeSetController extends Controller
{
    use AlertMessage;

    public $module = "Attribute Set";

    public function index(Request $request)
    {
        $grid = (new Grid())
            ->setQuery(AttributeSet::query())
            ->setColumns([
                [
                    'field' => 'attribute_set_name',
                    'label' => 'Name',
                    'sortable' => true,
                    'filterable' => true
                ],

            ])->setButtons([
                [
                    'label' => 'Edit',
                    'icon' => 'edit',
                    'url' => function ($item) {
                        return route('admin.attribute-set.edit', $item->attribute_set_id);
                    }
                ]
            ])->generate();

        return view('admin.attribute.attribute-set.grid', compact('grid'));
    }

    public function create()
    {
        $entities = Entity::pluck('entity_code', 'entity_id');

        return view('admin.attribute.attribute-set.create')->with('entities', $entities);
    }

    public function store(Request $request)
    {
        $this->validator()->validate();

        $attributeSet = AttributeSet::create([
            'attribute_set_name' => $request->input('attribute_set_name'),
            'entity_id' => $request->input('entity_id')
        ]);

        return redirect()->route('admin.attribute-set.edit', ['attribute_set' => $attributeSet->attribute_set_id])->with($this->createResponse());
    }

    public function edit(AttributeSet $attributeSet, Request $request)
    {
        $entities = Entity::pluck('entity_code', 'entity_id');

        return view('admin.attribute.attribute-set.edit')
            ->with(compact('entities', 'attributeSet'));
    }

    public function update(AttributeSet $attributeSet, Request $request)
    {
        $this->validator()->validate();

        $attributeSet->fill($request->all())->save();

        return redirect()->back()->with($this->updateResponse());
    }

    public function destroy(AttributeSet $attributeSet, Request $request)
    {
        $attributeSet->delete();

        return redirect()->route('admin.attribute-set.index')->with($this->deleteResponse());
    }

    protected function validator()
    {
        $attributeSetId = \request()->route('attribute_set') ? \request()->route('attribute_set')->attribute_set_id : null;

        return Validator::make(\request()->all(), [
            'attribute_set_name' => ['required', 'string', 'max:100', Rule::unique('attribute_sets', 'attribute_set_name')->ignore(
                $attributeSetId,
                'attribute_set_id'
            )],
            'entity_id' => ['required']
        ]);
    }
}
