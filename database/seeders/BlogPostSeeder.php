<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    private const THUMBNAIL_WIDTH = 800;

    private const THUMBNAIL_HEIGHT = 450;

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('blog');

        $author = Employee::first();

        $categories = BlogCategory::pluck('id', 'slug');

        $posts = [
            [
                'title' => ['en' => 'Top 10 Cars to Buy in 2025', 'ar' => 'أفضل 10 سيارات للشراء في 2025'],
                'slug' => 'top-10-cars-2025',
                'excerpt' => [
                    'en' => 'Discover the best cars hitting the market this year with our comprehensive ranking.',
                    'ar' => 'اكتشف أفضل السيارات التي تصل إلى السوق هذا العام مع ترتيبنا الشامل.',
                ],
                'content' => [
                    'en' => '<p>The automotive industry is evolving rapidly, and 2025 brings an exciting lineup of vehicles. From electric SUVs to luxury sedans, there is something for every buyer. In this guide, we review the top contenders based on performance, safety, value, and innovation.</p><p>Whether you are looking for a family-friendly SUV like the Toyota Land Cruiser or a sporty sedan like the BMW 5 Series, our list covers the most compelling options available in the Saudi market today.</p>',
                    'ar' => '<p>تتطور صناعة السيارات بسرعة، وين bringing 2025 مجموعة مثيرة من المركبات. من سيارات الدفع الرباعي الكهربائية إلى السيدان الفاخرة، هناك شيء لكل مشتري. في هذه المجلد، نراجع أقوى المرشحين بناءً على الأداء والسلامة والقيمة والابتكار.</p><p>سواء كنت تبحث عن سيارة دفع رباعي مناسبة للعائلة مثل تويوتا لاند كروزر أو سيدان رياضية مثل بي إم دبليو الفئة الخامسة، تغطي قائمتنا أقوى الخيارات المتاحة في السوق السعودي اليوم.</p>',
                ],
                'meta_title' => 'Top 10 Cars 2025 | GR Motors',
                'meta_description' => 'Explore the best cars to buy in 2025 with our expert reviews and rankings.',
                'meta_keywords' => 'cars,2025,buying guide,top cars',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'category_slugs' => ['car-reviews', 'buying-guides'],
                'seed' => 'blog-post-1',
            ],
            [
                'title' => ['en' => 'Electric Vehicles: The Future of Driving', 'ar' => 'السيارات الكهربائية: مستقبل القيادة'],
                'slug' => 'electric-vehicles-future',
                'excerpt' => [
                    'en' => 'An in-depth look at how electric vehicles are transforming the automotive landscape.',
                    'ar' => 'نظرة معمقة على كيفية تحول السيارات الكهربائية لمشهد السيارات.',
                ],
                'content' => [
                    'en' => '<p>Electric vehicles are no longer a niche market. With major manufacturers investing billions, EVs are becoming more affordable and accessible. Saudi Arabia is also embracing this shift with new infrastructure and incentives.</p><p>This article explores the advantages of electric driving, from lower running costs to reduced environmental impact, and what to expect from the EV market in the coming years.</p>',
                    'ar' => '<p>لم تعد السيارات الكهربائية سوقاً متخصصاً. مع استثمار الشركات الكبرى مليارات الدولارات، أصبحت السيارات الكهربائية أكثر قدرة على التوفر والسهولة. ت拥抱 المملكة العربية العربية هذا التحول أيضاً ببنية تحتية جديدة وتحفيزات.</p><p>يستكشف هذا المقال مزايا القيادة الكهربائية، من تكاليف التشغيل المنخفضة إلى تقليل الأثر البيئي، وما يمكن توقعه من سوق السيارات الكهربائية في السنوات القادمة.</p>',
                ],
                'meta_title' => 'Electric Vehicles Future | GR Motors',
                'meta_description' => 'Learn how electric vehicles are shaping the future of transportation.',
                'meta_keywords' => 'electric vehicles,ev,future,green driving',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'category_slugs' => ['technology', 'industry-news'],
                'seed' => 'blog-post-2',
            ],
            [
                'title' => ['en' => 'How to Choose the Right Car for Your Family', 'ar' => 'كيف تختار السيارة المناسبة لعائلتك'],
                'slug' => 'choose-right-car-family',
                'excerpt' => [
                    'en' => 'A practical guide to selecting a vehicle that fits your family needs and budget.',
                    'ar' => 'دليل عملي لاختيار مركبة تناسب احتياجات عائلتك وميزانيتك.',
                ],
                'content' => [
                    'en' => '<p>Choosing a family car requires careful consideration of space, safety, reliability, and fuel efficiency. A good family vehicle should accommodate everyone comfortably while providing peace of mind on every journey.</p><p>We break down the key factors to consider, from seating capacity and cargo space to advanced safety features like adaptive cruise control and lane-keeping assist.</p>',
                    'ar' => '<p>يتطلب اختيار سيارة عائلية مراعاة دقيقة للمساحة والسلامة والموثوقية وكفاءة الوقود. يجب أن تسع المركبة العائلية الجيدة الجميع بشكل مريح بينما توفر راحة البال في كل رحلة.</p><p>نفصل العوامل الرئيسية التي يجب مراعاتها، من عدد المقاعد ومساحة الأمتعة إلى ميزات الأمان المتقدمة مثل مثبت السرعة التكيفي والحفاظ على المسار.</p>',
                ],
                'meta_title' => 'Family Car Guide | GR Motors',
                'meta_description' => 'Find the perfect family car with our expert buying guide.',
                'meta_keywords' => 'family car,buying guide,safety,spacious',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(8),
                'category_slugs' => ['buying-guides'],
                'seed' => 'blog-post-3',
            ],
            [
                'title' => ['en' => 'Essential Car Maintenance Tips for Summer', 'ar' => 'نصائح صيانة السيارات الأساسية للصيف'],
                'slug' => 'car-maintenance-summer-tips',
                'excerpt' => [
                    'en' => 'Keep your car running smoothly during the hot summer months with these maintenance tips.',
                    'ar' => 'حافظ على تشغيل سيارتك بسلاسة خلال الأشهر الصيفية الحارة مع نصائح الصيانة هذه.',
                ],
                'content' => [
                    'en' => '<p>Summer heat can take a toll on your vehicle. From tire pressure to coolant levels, there are several things you should check to ensure your car performs optimally in high temperatures.</p><p>In this article, we cover the most important maintenance tasks including oil changes, battery checks, air conditioning servicing, and tire inspections to keep you safe on the road all summer long.</p>',
                    'ar' => '<p>يمكن أن تؤدي حرارة الصيف إلى ضرر بمركبتك. من ضغط الإطارات إلى مستويات التبريد، هناك عدة أشياء يجب فحصها لضمان أداء سيارتك بأفضل طريقة في درجات الحرارة العالية.</p><p>في هذا المقال، نغطي أهم مهام الصيانة بما في ذلك تغيير الزيت وفحص البطارية وخدمة تكييف الهواء وفحص الإطارات للحفاظ على سلامتك على الطريق طوال الصيف.</p>',
                ],
                'meta_title' => 'Summer Car Maintenance Tips | GR Motors',
                'meta_description' => 'Essential maintenance tips to keep your car in top shape during summer.',
                'meta_keywords' => 'car maintenance,summer,tips,heat,cooling',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(12),
                'category_slugs' => ['maintenance-tips'],
                'seed' => 'blog-post-4',
            ],
            [
                'title' => ['en' => 'BMW vs Toyota: Which Brand Is Right for You?', 'ar' => 'بي إم دبليو ضد تويوتا: أي العلامات التجارية مناسبة لك؟'],
                'slug' => 'bmw-vs-toyota-comparison',
                'excerpt' => [
                    'en' => 'A detailed comparison of two of the most popular car brands in the Saudi market.',
                    'ar' => 'مقارنة مفصلة بين اثنين من أشهر علامات السيارات التجارية في السوق السعودي.',
                ],
                'content' => [
                    'en' => '<p>BMW and Toyota represent two distinct philosophies in automotive manufacturing. Toyota is renowned for reliability and value, while BMW is celebrated for performance and luxury.</p><p>In this comparison, we examine both brands across key categories including build quality, technology, resale value, and total cost of ownership to help you make an informed decision.</p>',
                    'ar' => '<p>يمثل بي إم دبليو وتويوتا فلسفتين متميزتين في صناعة السيارات. تشتهر تويوتا بالموثوقية والقيمة، بينما يُحتفى بـ بي إم دبليو بالأداء والفخامة.</p><p>في هذه المقارنة، نفحص كلا العلامتين التجارية عبر فئات رئيسية بما في ذلك جودة البناء والتكنولوجيا وقيمة إعادة البيع وملكية التكلفة الإجمالية لمساعدتك على اتخاذ قرار مدروس.</p>',
                ],
                'meta_title' => 'BMW vs Toyota Comparison | GR Motors',
                'meta_description' => 'Compare BMW and Toyota to find the best brand for your needs.',
                'meta_keywords' => 'bmw,toyota,comparison,brand comparison',
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(15),
                'category_slugs' => ['car-reviews', 'buying-guides'],
                'seed' => 'blog-post-5',
            ],
            [
                'title' => ['en' => 'New Saudi Auto Regulations You Need to Know', 'ar' => 'اللوائح السيارات السعودية الجديدة التي تحتاج لمعرفتها'],
                'slug' => 'saudi-auto-regulations-2025',
                'excerpt' => [
                    'en' => 'Stay informed about the latest automotive regulations and policies in Saudi Arabia.',
                    'ar' => 'ابق على اطلاع بأحدث لوائح وسياسات السيارات في المملكة العربية السعودية.',
                ],
                'content' => [
                    'en' => '<p>Saudi Arabia has introduced several new automotive regulations that every car owner and buyer should be aware of. These changes affect vehicle registration, insurance requirements, and emissions standards.</p><p>This article breaks down the key regulatory changes and what they mean for consumers in the Kingdom.</p>',
                    'ar' => '<p>أدخلت المملكة العربية السعودية عدة لوائح سيارات جديدة يجب على كل مالك ومشتري سيارات أن يكون على علم بها. تؤثر هذه التغييرات على تسجيل المركبات ومتطلبات التأمين ومعايير الانبعاثات.</p><p>يشرح هذا المقال التغييرات التنظيمية الرئيسية وما تعنيه للمستهلكين في المملكة.</p>',
                ],
                'meta_title' => 'Saudi Auto Regulations 2025 | GR Motors',
                'meta_description' => 'Everything you need to know about new Saudi automotive regulations.',
                'meta_keywords' => 'saudi arabia,regulations,auto laws,2025',
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(20),
                'category_slugs' => ['industry-news'],
                'seed' => 'blog-post-6',
            ],
        ];

        foreach ($posts as $data) {
            $categorySlugs = $data['category_slugs'];
            unset($data['category_slugs'], $data['seed']);

            $post = BlogPost::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    ...$data,
                    'employee_id' => $author?->id,
                ],
            );

            if ($post->thumbnail) {
                $this->command?->info("  Skipping thumbnail for [{$post->getTranslation('title', 'en')}] — already set.");

                $post->categories()->syncWithoutDetaching($categories->filter(fn ($id, $slug) => in_array($slug, $categorySlugs))->values()->all());

                continue;
            }

            $this->seedThumbnail($post);
            $post->categories()->syncWithoutDetaching($categories->filter(fn ($id, $slug) => in_array($slug, $categorySlugs))->values()->all());
        }
    }

    private function seedThumbnail(BlogPost $post): void
    {
        $slug = $post->slug;
        $url = "https://picsum.photos/seed/{$slug}/".self::THUMBNAIL_WIDTH.'/'.self::THUMBNAIL_HEIGHT;

        $contents = file_get_contents($url);

        if ($contents === false) {
            $this->command?->warn("  Failed to download thumbnail for [{$post->getTranslation('title', 'en')}].");

            return;
        }

        $filename = Str::random(40).'.webp';
        $path = 'blog/'.$filename;

        Storage::disk('public')->put($path, $contents);

        $post->update(['thumbnail' => $path]);

        $this->command?->info("  Thumbnail saved for [{$post->getTranslation('title', 'en')}]: {$path}");
    }
}
