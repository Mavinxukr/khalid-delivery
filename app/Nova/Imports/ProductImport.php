<?php


namespace App\Nova\Imports;




use App\Models\Product\Menu;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Excel;


class ProductImport implements ToCollection
{
    private $provider;
    private $data;
    private $category;

    public function __construct(int $provider, int $category = null, $data = null)
    {
        $this->provider     = $provider;
        $this->data         = $data;
        $this->category     = $category;
    }

    public function collection(Collection $rows)
    {
        unset($rows[0]);
        foreach ($rows as $row)
        {
            (strlen($row[5]) > 0) ?
                $parent = Product::whereTitle($row[5])->first()->id :
                $parent = null;
            (is_null($parent)) ? $provider = $this->provider : $provider = null;

            Product::create([
                'title'           => $row[0] ?? 'null',
                'description'     => $row[1],
                'type'            => $row[2],
                'price'           => floatval($row[3]),
                'image'           => $row[4],
                'has_ingredients' => null,
                'provider_id'     => $provider,
                'parent_id'       => $parent,
                'weight'          => $row[6] ?? null,
                'query'           => $row[7] ?? null,
                'answer_type'     => $row[8] ?? null,
                'category_id'     => $this->category
            ]);
            is_null($parent) ?:
                Product::whereId($parent)->update(['has_ingredients' => 1]);
        }
    }

    public static function import($data)
    {
        $res =  Excel::import(new MenuImport(1, $data));

    }
}
