# Quickstart: API Base Code

## Prerequisites

- Laravel project with existing API routes
- Sanctum installed and configured
- Basic understanding of the existing controller structure

## Usage

### 1. Creating a New API Controller

```php
namespace App\Http\Controllers\Api;

use App\Http\Api\Responses\ApiResponseBuilder;

class ProductController extends ApiBaseController
{
    public function __construct(
        private ApiResponseBuilder $response
    ) {}

    public function index()
    {
        $products = Product::paginate(15);
        return $this->response->paginated($products, 'Products retrieved successfully');
    }

    public function show(Product $product)
    {
        return $this->response->ok($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return $this->response->created($product, 'Product created successfully');
    }
}
```

### 2. Defining a Request with Validation

```php
namespace App\Http\Requests\Api;

class StoreProductRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
```

### 3. Throwing API Exceptions

```php
use App\Http\Api\Exceptions\NotFoundException;
use App\Http\Api\Exceptions\ValidationException;

throw new NotFoundException('Product not found');
throw new ValidationException(['email' => ['The email is invalid.']]);
```

### 4. Using the Builder Directly

```php
return app(ApiResponseBuilder::class)
    ->success(true)
    ->message('Custom response')
    ->data(['key' => 'value'])
    ->meta(['processed_at' => now()])
    ->build();
```

## Testing

```php
// Test response structure
$response = $this->getJson('/api/products');
$response->assertJsonStructure([
    'success',
    'message',
    'data',
    'errors',
    'meta'
]);
```
