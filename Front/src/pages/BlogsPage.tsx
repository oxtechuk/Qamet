import { useState, useMemo, useCallback } from "react";
import { useTranslation } from "react-i18next";
import { useInfiniteQuery } from "@tanstack/react-query";
import BlogsPageHero from "../components/blogs/BlogsPageHero";
import LatestArticlesSection from "../components/blogs/LatestArticlesSection";
import ContactCtaSection from "../components/ContactCtaSection";
import { getBlogs } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { postToCardProps } from "../utils/blog";
import { useSEO } from "../utils/useSEO";

export default function BlogsPage() {
  const { t } = useTranslation();
  useSEO(t("nav.blog"), t("blogPage.hero.description"));
  const language = useLanguageStore((s) => s.language);
  const [activeCategory, setActiveCategory] = useState("all");

  const {
    data: blogResponse,
    fetchNextPage,
    hasNextPage,
    isFetchingNextPage,
  } = useInfiniteQuery({
    queryKey: ["blogs", language],
    queryFn: ({ pageParam }) => getBlogs(pageParam as number, 6),
    initialPageParam: 1,
    getNextPageParam: (lastPage) =>
      lastPage.meta.current_page < lastPage.meta.last_page
        ? lastPage.meta.current_page + 1
        : undefined,
  });

  const categories = useMemo(() => {
    const apiCategories = blogResponse?.pages?.[0]?.meta.categories ?? [];
    return [
      { label: language === "ar" ? "الكل" : "All", value: "all" },
      ...apiCategories.map((c) => ({ label: c.name, value: c.slug })),
    ];
  }, [blogResponse, language]);

  const featuredPost = useMemo(() => {
    const firstPost = blogResponse?.pages?.[0]?.data?.[0];
    if (!firstPost) return undefined;
    return postToCardProps(firstPost, language, t);
  }, [blogResponse, language, t]);

  const articles = useMemo(() => {
    if (!blogResponse?.pages) return [];
    const allPosts = blogResponse.pages.flatMap((page) => page.data);
    return allPosts.map((post) => postToCardProps(post, language, t));
  }, [blogResponse, language, t]);

  const handleLoadMore = useCallback(() => {
    if (hasNextPage && !isFetchingNextPage) {
      fetchNextPage();
    }
  }, [hasNextPage, isFetchingNextPage, fetchNextPage]);

  return (
    <>
      <BlogsPageHero
        badgeText={blogResponse?.pages?.[0]?.meta.hero.badge || t("blogPage.hero.badge")}
        title={blogResponse?.pages?.[0]?.meta.hero.title || t("blogPage.hero.title")}
        description={blogResponse?.pages?.[0]?.meta.hero.subtitle || t("blogPage.hero.description")}
        categories={categories}
        activeCategory={activeCategory}
        onCategoryChange={setActiveCategory}
        featuredPost={featuredPost}
      />

      <LatestArticlesSection
        title={t("blogPage.latestArticles.title")}
        articles={articles}
        loadMoreText={isFetchingNextPage ? t("blogPage.latestArticles.loading") : t("blogPage.latestArticles.loadMore")}
        hasMore={!!hasNextPage}
        onLoadMore={handleLoadMore}
      />

      <ContactCtaSection
        badgeText={t("allCarsPage.contactBadge")}
        titleWhite={t("allCarsPage.contactTitleWhite")}
        titleOrange={t("allCarsPage.contactTitleOrange")}
        description={t("allCarsPage.contactDescription")}
        phoneText={t("allCarsPage.contactPhone")}
        phoneHref="tel:+966500000000"
        whatsappText={t("allCarsPage.contactWhatsapp")}
        
        sectionBgColor="var(--brand-CTA-BG-color)"
      />
    </>
  );
}
