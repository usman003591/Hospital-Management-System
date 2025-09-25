<?php
namespace App\Livewire\Brands;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand; // Create this model

class AllBrandsListing extends Component
{
    use WithPagination;

    public $q = '';
    public $status = '';
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['q', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $data = Brand::query()
            ->select('brands.*')
            ->when($this->q !== '', function ($query) {
                return $query->where('brands.brand_name', 'ILIKE', "%{$this->q}%"); // Adjust 'name' to actual column
            })
            ->when($this->status !== '', function ($query) {
                return $query->where('brands.status', $this->status);
            })
            ->orderBy('brands.created_at', 'desc')
            ->paginate(10);

        return view('livewire.brands.all-brands-listing', [
            'data' => $data,
            'page' => 'brands',
        ]);
    }
}