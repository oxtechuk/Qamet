import { useMemo } from "react";
import { useTranslation } from "react-i18next";
import { useQuery } from "@tanstack/react-query";
import { useParams } from "react-router-dom";
import BlogArticleContent from "../components/blogs/BlogArticleContent";
import BlogDetailsHero from "../components/blogs/BlogDetailsHero";
import RelatedArticlesSection from "../components/blogs/RelatedArticlesSection";
import { getBlogBySlug } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { getImageUrl } from "../constants/app-images";
import { formatBlogDate, formatBlogReadTime, parseBlogContent, postToCardProps } from "../utils/blog";
import { useSEO } from "../utils/useSEO";
import type { BlogPost, BlogCategory } from "../types/blogs.types";

export default function BlogDetailsPage() {
  const { t } = useTranslation();
  useSEO(t("nav.blog"), t("blogPage.details.metaDescription"));
  const { slug } = useParams<{ slug: string }>();
  const language = useLanguageStore((s) => s.language);

  const {
    data: blog,
    isLoading,
    isError,
  } = useQuery({
    queryKey: ["blog", slug, language],
    queryFn: () => getBlogBySlug(slug!),
    enabled: !!slug,
  });

  const date = useMemo(
    () =>
      blog ? formatBlogDate(blog.published_at, language) : "",
    [blog, language]
  );

  const readTime = useMemo(
    () =>
      blog ? formatBlogReadTime(blog.reading_time, language) : "",
    [blog, language]
  );

  const sections = useMemo(
    () => (blog ? parseBlogContent(blog.content) : []),
    [blog]
  );

  const relatedArticles = useMemo(
    () =>
      blog?.related_posts?.map((post: BlogPost) =>
        postToCardProps(post, language, t)
      ) ?? [],
    [blog, language, t]
  );

  if (isLoading) {
    return (
      <section className="flex h-[60vh] items-center justify-center bg-[#F0F2F5]">
        <p className="text-[18px] text-[#6B7280]">
          {t("blogPage.details.page.loading")}
        </p>
      </section>
    );
  }

  if (isError || !blog) {
    return (
      <section className="flex h-[60vh] items-center justify-center bg-[#F0F2F5]">
        <p className="text-[18px] text-[#6B7280]">
          {t("blogPage.details.page.error")}
        </p>
      </section>
    );
  }

  return (
    <>
      <BlogDetailsHero
        category={blog.categories.map((c: BlogCategory) => c.name).join(", ") || ""}
        title={blog.title}
        authorName={blog.employee.name || t("blogPage.hero.featuredPost.author.name")}
        authorRole={blog.employee.role || t("blogPage.hero.featuredPost.author.role")}
        authorImage={getImageUrl(blog.employee.avatar) || "/images/blogs/author.png"}
        date={date}
        readTime={readTime}
        image={getImageUrl(blog.thumbnail) || "/images/blog.png"}
      />

      <BlogArticleContent sections={sections} />

      {relatedArticles.length > 0 && (
        <RelatedArticlesSection
          title={t("blogPage.details.related.title")}
          articles={relatedArticles}
        />
      )}
    </>
  );
}
