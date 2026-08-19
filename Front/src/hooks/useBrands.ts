import { useState, useMemo } from "react";
import { useQuery } from "@tanstack/react-query";
import { useNavigate } from "react-router-dom";
import { getBrands } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import { getLocalizedName } from "../utils/localized-name";
import type { IBrandCardProps } from "../interfaces/IBrandCardProps";
import type { IUseBrandsReturn } from "../interfaces/IUseBrandsReturn";

export function useBrands(): IUseBrandsReturn {
  const language = useLanguageStore((s) => s.language);
  const navigate = useNavigate();
  const [search, setSearch] = useState("");

  const { data: brands, isLoading } = useQuery({
    queryKey: ["brands", language],
    queryFn: () => getBrands(),
    staleTime: 5 * 60 * 1000,
  });

  const brandCards: IBrandCardProps[] = useMemo(() => {
    if (!brands) return [];
    let list = brands;
    if (search.trim()) {
      const q = search.trim().toLowerCase();
      list = list.filter(
        (b) =>
          getLocalizedName(b.name, language).toLowerCase().includes(q) ||
          b.slug?.toLowerCase().includes(q),
      );
    }
    return list.map((b) => ({
      id: b.id,
      name: getLocalizedName(b.name, language),
      logo: getImageUrl(b.logo) || APP_IMAGES.BRAND_PLACEHOLDER,
      onClick: () => navigate(`/cars?brands=${b.id}`),
    }));
  }, [brands, search, navigate, language]);

  return { brandCards, search, setSearch, isLoading };
}
