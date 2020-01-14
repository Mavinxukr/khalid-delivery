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
           Product::create([
                'title'         => $row[0] ?? 'null',
                'description'   => $row[1],
                'product'       => $row[2],
                'price'         => floatval($row[3]),
                'image'         => $row[4],
                'provider_id'   => $this->provider,
                'category_id'   => $this->category

            ]);
        }
    }

    public static function import($data)
    {
        $res =  Excel::import(new MenuImport(1, $data));

    }
}
