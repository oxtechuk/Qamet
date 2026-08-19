# Laravel + React — Full Performance Audit, Debugging & Performance Refactoring

أنت Senior Full-Stack Performance Engineer متخصص في **Laravel + React + MySQL + REST APIs**.

لدي مشروع قديم تم تطويره وتعديله عدة مرات، وأصبح يحتوي على كود متراكم وطلبات API كثيرة وبطء ملحوظ رغم أن المشروع صغير، وتم بالفعل تطبيق:

- Lazy Loading للصور
- Image Compression
- Skeleton Loading
- Basic frontend optimization

لكن الموقع ما زال بطيئًا جدًا.

من Network panel ألاحظ أن بعض API requests ترجع:

```text
500 Internal Server Error
```

وبعض Requests تستغرق تقريبًا:

```text
1 - 1.5 seconds
```

وهذا يحدث حتى في صفحات بسيطة مثل:

```text
/home
/about
/brands
```

المطلوب منك **عدم افتراض أن المشكلة من الصور أو React فقط**.

أريد منك عمل **Full Performance Audit + Root Cause Analysis + Safe Refactoring** للمشروع بالكامل.

---

# 1. ابدأ بالتشخيص وليس بالتعديل

قبل تعديل أي ملف:

افحص المشروع بالكامل وحدد:

```text
Laravel Version
PHP Version
React Version
Vite Version
Database
API Architecture
Authentication
Caching
Queue
Storage
Image Handling
Build Configuration
Environment Configuration
```

افحص:

```text
composer.json
package.json
vite.config.*
.env
routes/api.php
routes/web.php
app/Http/Controllers
app/Http/Requests
app/Http/Resources
app/Models
app/Services
app/Repositories
resources/
frontend/
src/
database/
config/
public/
```

إذا كان هيكل المشروع مختلفًا، اكتشف الهيكل أولًا ولا تفترض أسماء folders.

---

# 2. أهم شيء: اكتشف سبب الـ 500 Errors

أي API ترجع:

```text
500
```

تعتبر مشكلة Critical.

ابحث عن سببها الحقيقي من:

```text
storage/logs/laravel.log
```

وافحص Stack Trace.

لا تقم فقط بإخفاء الـ error أو تحويل Response إلى 200.

حدد:

```text
Exception
File
Line
Controller
Service
Model
Query
Relationship
Resource
Middleware
```

ثم أصلح Root Cause.

أي API فيها 500 يجب أن تصبح مستقرة قبل اعتبار المهمة مكتملة.

---

# 3. اعمل API Performance Audit

حلل كل API endpoint مستخدم بواسطة React.

لكل Endpoint حدد:

```text
Endpoint
HTTP Method
Controller
Middleware
Database Queries
Number of Queries
Execution Time
Response Size
N+1 Problems
External API Calls
Cache Usage
```

ركز بشكل خاص على:

```text
/home
/about
/brands
```

وأي endpoint يتم استدعاؤه أثناء فتح الصفحة.

ابحث عن:

- Controllers تقوم بعمل Queries كثيرة
- Queries داخل loops
- N+1 queries
- Lazy-loaded Eloquent relationships
- `Model::all()`
- `get()` بدون pagination
- `with()` ناقصة
- `where()` متكرر
- Queries متكررة لنفس البيانات
- Database calls داخل Resources
- Database calls داخل Accessors
- Database calls داخل Mutators
- Database calls داخل loops
- External API calls داخل request lifecycle
- Heavy calculations داخل Controller

---

# 4. اكتشف N+1 Queries

افحص كل:

```php
foreach
map
filter
each
Resource
Collection
```

وابحث عن شيء مثل:

```php
foreach ($brands as $brand) {
    $brand->products;
}
```

أو:

```php
$brand->category->name
```

أو:

```php
$product->images
```

بدون eager loading.

استبدلها عند الحاجة بـ:

```php
with()
load()
withCount()
withSum()
```

لكن لا تستخدم eager loading بشكل عشوائي.

قم بتحميل العلاقات المطلوبة فقط.

---

# 5. افحص Database Performance

افحص جميع Models وQueries المرتبطة بالصفحات الرئيسية.

ابحث عن columns مستخدمة باستمرار في:

```text
WHERE
JOIN
ORDER BY
GROUP BY
FOREIGN KEY
SEARCH
```

وتأكد من وجود Indexes مناسبة.

افحص migrations الموجودة.

إذا كان هناك نقص في indexes، أنشئ migrations جديدة بدل تعديل migrations القديمة.

مثال:

```php
$table->index('slug');
$table->index('status');
$table->index('brand_id');
$table->index(['status', 'created_at']);
```

لكن لا تضف Indexes عشوائية.

كل Index يجب أن يكون له سبب واضح.

---

# 6. افحص Slow Queries

استخدم Laravel Query Logging / Telescope / Debugbar إن كانت البيئة Development.

حدد:

```text
Queries > 50ms
Queries > 100ms
Queries > 500ms
```

حدد أبطأ Queries في المشروع.

إذا كانت البيئة Production، لا تقم بتفعيل Debugbar أو verbose query logging للمستخدمين.

---

# 7. راجع Controllers

لا أريد Controllers ضخمة مثل:

```php
public function home()
{
    // 300+ lines
}
```

افصل Business Logic عند الحاجة إلى:

```text
Services
Actions
Queries
Resources
Form Requests
```

لكن:

**لا تعمل Over-Engineering.**

لا تنشئ عشرات Classes بدون داعٍ.

الهدف:

```text
Simple
Fast
Maintainable
Testable
```

---

# 8. API Resources

راجع:

```php
JsonResource
ResourceCollection
```

وتأكد أن الـ Resource لا يقوم بعمل Queries إضافية.

ممنوع وجود:

```php
$model->relation
```

داخل Resource إذا كانت العلاقة غير محملة.

استخدم:

```php
whenLoaded()
```

عند الحاجة.

وتأكد أن Response يحتوي فقط على البيانات التي يحتاجها React.

لا ترجع:

```text
50 fields
```

إذا كانت الصفحة تحتاج:

```text
8 fields
```

---

# 9. API Response Optimization

قلل حجم JSON responses.

افحص:

```text
unused fields
nested objects
duplicate data
large collections
unnecessary metadata
```

استخدم Pagination للبيانات الكبيرة.

مثال:

```php
paginate(20)
```

بدل:

```php
get()
```

إذا كانت البيانات كثيرة.

---

# 10. React Network Audit

افحص جميع React components.

خصوصًا:

```text
useEffect
useQuery
axios
fetch
API services
custom hooks
```

ابحث عن:

### Duplicate Requests

مثال:

```text
/home
/home
/home
/brands
/brands
```

إذا كانت نفس API تضرب أكثر من مرة بدون سبب، أصلحها.

---

# 11. افحص useEffect

ابحث عن:

```js
useEffect(() => {
    fetchData();
}, []);
```

ثم افحص:

```text
StrictMode
dependencies
component mounting
parent re-render
route changes
```

وتأكد أن الـ API لا يتم استدعاؤها عدة مرات بسبب:

```text
rerender
state update
unstable dependencies
component remount
```

---

# 12. استخدم Data Fetching Architecture صحيحة

إذا المشروع يستخدم:

```text
React Query / TanStack Query
```

استخدم:

```text
Query caching
staleTime
gcTime
deduplication
prefetching
request cancellation
```

إذا المشروع لا يستخدم React Query، قيّم هل إدخاله مناسب للمشروع.

لا تضف Library كبيرة إذا لم تكن ضرورية.

---

# 13. Parallel API Requests

إذا الصفحة تعمل:

```text
GET /home
GET /brands
GET /categories
GET /settings
```

بشكل Sequential:

```text
request
wait
request
wait
request
wait
```

غيّرها إلى Parallel Requests عند إمكانية ذلك.

مثال:

```js
Promise.all([
    getHome(),
    getBrands(),
    getCategories(),
    getSettings()
])
```

أو استخدم Data Fetching library مناسبة.

---

# 14. لا تجعل React ينتظر بيانات غير مهمة

قسّم البيانات إلى:

### Critical

البيانات المطلوبة للرسم الأول.

### Secondary

يمكن تحميلها بعد ظهور الصفحة.

### Lazy

يمكن تحميلها عند الحاجة فقط.

مثال:

```text
Hero
Main Content
Primary Products
```

تكون Critical.

أما:

```text
Footer
Secondary Sections
Recommendations
Analytics
```

يمكن تحميلها لاحقًا إذا كان ذلك مناسبًا.

---

# 15. React Rendering Performance

ابحث عن:

```text
unnecessary rerenders
large lists
expensive calculations
unstable props
inline objects
inline functions
```

استخدم عند الحاجة فقط:

```text
React.memo
useMemo
useCallback
```

لا تستخدمها عشوائيًا.

إذا توجد Lists كبيرة، استخدم virtualization فقط إذا كانت الحاجة فعلية.

---

# 16. Vite / Bundle Audit

افحص:

```text
vite.config
package.json
bundle size
dependencies
dynamic imports
code splitting
```

ابحث عن Libraries ضخمة يتم تحميلها بدون حاجة.

حدد:

```text
Largest JS chunks
Largest CSS
Unused dependencies
Duplicate dependencies
```

استخدم:

```js
React.lazy()
dynamic import()
```

للصفحات أو Features الثقيلة.

---

# 17. Images

أنا بالفعل أستخدم:

```text
Lazy Loading
Compression
Skeleton
```

لذلك لا تعتبر أن هذه هي الحل الأساسي.

راجع فقط هل يوجد:

```text
Oversized images
Wrong dimensions
PNG بدل WebP/AVIF
Images أكبر من مساحة العرض
Missing width/height
Layout shift
Images loaded before needed
```

استخدم modern formats عند دعمها.

مثال:

```text
AVIF
WebP
```

لكن لا تعيد تنفيذ Lazy Loading بشكل عشوائي.

---

# 18. Laravel Cache

حدد البيانات التي لا تتغير باستمرار.

مثل:

```text
Settings
Brands
Categories
Menus
Static Content
SEO Data
```

واستخدم caching مناسب.

مثال:

```php
Cache::remember(
    'brands',
    3600,
    fn () => Brand::query()
        ->select(['id', 'name', 'slug', 'logo'])
        ->where('status', 1)
        ->get()
);
```

لكن:

**لا تعمل Cache لكل شيء.**

حدد ما يستحق caching بناءً على الاستخدام.

---

# 19. Cache Invalidation

إذا استخدمت Cache، يجب أن يكون هناك strategy واضحة لمسح/تحديث cache عند:

```text
create
update
delete
publish
unpublish
```

لا أريد stale data بدون سبب.

---

# 20. Laravel Config / Route / View Cache

افحص Production configuration.

تأكد من استخدام:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

إذا كانت مناسبة للـ deployment الحالي.

لا تشغل هذه الأوامر بشكل أعمى أثناء Development إذا كانت ستؤثر على workflow.

---

# 21. OPcache / PHP

افحص Production PHP configuration.

تأكد من:

```text
OPcache
memory_limit
max_execution_time
realpath_cache
```

وأي إعدادات مؤثرة على performance.

لا ترفع:

```text
memory_limit
```

كحل لمشكلة Performance بدون معرفة السبب.

---

# 22. Laravel Middleware Audit

راجع Middleware الخاصة بالـ API.

ابحث عن Middleware تقوم بـ:

```text
Database Query
External API Request
Heavy Calculation
Session Loading
Authentication overhead
```

كل Request يجب أن يكون lightweight قدر الإمكان.

---

# 23. Authentication

افحص Authentication system.

خصوصًا:

```text
Sanctum
JWT
Session
Token verification
User queries
Permissions
Roles
```

تأكد أن كل API request لا تقوم بعمل Queries غير ضرورية.

---

# 24. External API Calls

ابحث عن أي:

```php
Http::get()
Http::post()
Guzzle
Curl
```

داخل request lifecycle.

إذا كان External API بطيئًا:

```text
Timeout
Caching
Queue
Async processing
Fallback
```

حسب طبيعة العملية.

لا تجعل API request تنتظر خدمة خارجية بطيئة إذا لم تكن البيانات ضرورية للـ response.

---

# 25. Queue

أي عملية ثقيلة مثل:

```text
Email
Image Processing
Notifications
Reports
External API Sync
Heavy Processing
```

قيّم نقلها إلى:

```text
Laravel Queue
```

بدل تنفيذها أثناء HTTP request.

---

# 26. React API Error Handling

أي:

```text
500
404
401
422
429
```

يجب أن يكون لها handling واضح.

لا تجعل React يعيد Request بلا نهاية.

افحص:

```text
retry logic
axios interceptors
React Query retry
error boundaries
```

خصوصًا إذا كانت 500 errors تسبب repeated requests.

---

# 27. Critical Network Waterfall

استخدم Network waterfall لتحديد:

```text
DNS
TCP
TLS
TTFB
Download
API wait
JS execution
Rendering
```

الهدف ليس فقط تقليل file size.

الهدف معرفة:

**أين الوقت يضيع فعليًا؟**

---

# 28. TTFB

إذا كانت API تستغرق:

```text
1000ms+
```

لا تحاول حلها باستخدام React.

ابحث في Laravel عن:

```text
Database
Middleware
Controller
External API
Cache miss
PHP execution
Server configuration
```

---

# 29. API Compression

تأكد أن Server يدعم:

```text
Gzip
Brotli
```

للـ:

```text
JSON
JS
CSS
HTML
SVG
```

لكن لا تضغط الصور مرة أخرى إذا كانت already compressed formats.

---

# 30. HTTP Caching

راجع Headers:

```text
Cache-Control
ETag
Last-Modified
Content-Encoding
Content-Type
```

للـ static assets.

لا تستخدم caching قوي للـ API responses التي تحتاج real-time data.

---

# 31. React Build

افحص Production build وليس Development.

نفذ:

```bash
npm run build
```

ثم افحص output.

تأكد أن Production لا يحتوي على:

```text
source maps exposed unnecessarily
development libraries
debug logs
console spam
unused chunks
```

---

# 32. Laravel Production Mode

تحقق من:

```env
APP_ENV=production
APP_DEBUG=false
```

وتأكد أن التطبيق لا يعمل Debug mode في Production.

---

# 33. Logging

ابحث عن:

```text
console.log
console.error
dump()
dd()
var_dump()
print_r()
logger()
```

داخل hot paths.

لا تحذف useful error logging، لكن قلل logging المفرط في Production.

---

# 34. Database Connection

افحص:

```text
MySQL connection
persistent connections
connection latency
database host
DNS
```

إذا كان Database على Server مختلف، افحص network latency.

---

# 35. Frontend Architecture

افحص هل هناك:

```text
Huge App component
Global state causing rerenders
Everything loaded at startup
All pages imported statically
Duplicate API service logic
```

وقم بإعادة الهيكلة عند الحاجة.

---

# 36. لا تعيد بناء المشروع من الصفر

مهم جدًا:

**لا تقم بإعادة كتابة المشروع بالكامل.**

اعمل:

```text
Audit
Measure
Identify bottleneck
Fix
Measure again
```

احتفظ بالـ existing functionality.

لا تغير:

```text
Business Logic
API Contract
Database Schema
UI/UX
Routes
```

إلا إذا كان هناك سبب واضح ومثبت.

---

# 37. لا تعمل Optimization وهمية

ممنوع اعتبار هذه حلولًا كافية:

```text
إضافة Lazy Loading فقط
إضافة Skeleton فقط
إضافة useMemo في كل مكان
إضافة React.memo لكل Component
زيادة memory_limit
زيادة timeout
إضافة Cache لكل API
ضغط الصور فقط
```

أريد Root Cause حقيقي.

---

# 38. اعمل Performance Baseline

قبل التعديل سجل:

```text
Homepage Load Time
API TTFB
API Response Time
Number of Requests
Number of API Requests
JS Bundle Size
CSS Size
Image Size
Database Queries
Database Query Time
LCP
CLS
INP
```

بعد التعديلات سجل نفس الأرقام.

أريد مقارنة:

```text
BEFORE
AFTER
IMPROVEMENT %
```

---

# 39. ترتيب الأولويات

صنف المشاكل إلى:

## P0 — Critical

مثل:

```text
500 errors
Broken API
Fatal exceptions
Infinite retries
```

## P1 — High

مثل:

```text
1s+ API
N+1 queries
Heavy database queries
Duplicate API calls
Huge JS bundle
```

## P2 — Medium

مثل:

```text
Missing cache
Unnecessary rerenders
Unused dependencies
Large assets
```

## P3 — Low

مثل:

```text
Minor cleanup
Code style
Non-critical refactoring
```

---

# 40. المطلوب النهائي

قبل تنفيذ أي تعديلات، أعطني تقريرًا مختصرًا بالشكل:

```text
PERFORMANCE AUDIT

Critical Problems:
1.
2.
3.

Backend Problems:
1.
2.
3.

Database Problems:
1.
2.
3.

Frontend Problems:
1.
2.
3.

Network Problems:
1.
2.
3.

Image Problems:
1.
2.

Caching Problems:
1.
2.

Expected Bottleneck:
____________________
```

ثم:

```text
OPTIMIZATION PLAN

Phase 1:
Critical fixes

Phase 2:
Backend + Database

Phase 3:
React + Network

Phase 4:
Caching

Phase 5:
Build + Assets

Phase 6:
Final Testing
```

بعد موافقتي، نفذ التعديلات.

---

# 41. قواعد التنفيذ

أثناء التعديل:

1. لا تكسر أي Feature موجودة.
2. لا تغير API contract بدون سبب.
3. لا تحذف code لمجرد أنه يبدو قديمًا قبل التأكد أنه غير مستخدم.
4. لا تغير Database structure بدون migration.
5. لا تعمل massive refactor بدون داعٍ.
6. لا تضف dependencies إلا إذا كانت ضرورية.
7. لا تستخدم caching بدون invalidation strategy.
8. لا تستخدم memoization بشكل عشوائي.
9. لا تخفي 500 errors.
10. لا تجعل frontend يعيد requests بلا حدود.
11. لا تضف Lazy Loading إضافي لمجرد تحسين شكلي.
12. كل Optimization يجب أن يكون له سبب measurable.

---

# 42. Verification

بعد التنفيذ:

شغل:

```bash
composer install
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

وفي frontend:

```bash
npm install
npm run build
```

ثم اختبر:

```text
Homepage
About
Brands
All API endpoints
Authentication
Forms
Images
Navigation
Mobile
Desktop
```

وتأكد من:

```text
0 unexpected 500 errors
0 duplicate critical API requests
No N+1 queries
No broken images
No console errors
No infinite request loops
```

---

# 43. النتيجة المطلوبة

أريد الوصول إلى:

```text
Fast API Response
Low TTFB
Minimal Database Queries
No N+1
No Duplicate Requests
Optimized React Rendering
Optimized JS Bundle
Optimized Images
Proper HTTP Caching
Proper Laravel Caching
Stable APIs
Clean Architecture
```

وفي النهاية أعطني:

```text
FINAL PERFORMANCE REPORT

Before:
TTFB:
Page Load:
API Requests:
DB Queries:
Bundle Size:

After:
TTFB:
Page Load:
API Requests:
DB Queries:
Bundle Size:

Improvement:
%

Files Changed:
- 
- 
- 

Critical Fixes:
- 
- 
- 

Remaining Bottlenecks:
- 
- 
```

**ابدأ الآن بالـ audit فقط، ولا تعدل أي ملف قبل تحديد Root Cause للمشكلة.**