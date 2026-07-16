import { useState, useMemo } from "react";
import { useQuery } from "@tanstack/react-query";
import { useNavigate } from "react-router-dom";
import { getBrands } from "../services/api";
import { useLanguageStore } from "../store/language.store";
import { APP_IMAGES, getImageUrl } from "../constants/app-images";
import type { IBrandCardProps } from "../interfaces/IBrandCardProps";
import type { IUseBrandsReturn } from "../interfaces/IUseBrandsReturn";

export function useBrands(): IUseBrandsReturn {
  const language = useLanguageStore((s) => s.language);
  const navigate = useNavigate();
  const [search, setSearch] = useState("");

  const { data: brands, isLoading } = useQuery({
    queryKey: ["brands-page", language],
    queryFn: () => getBrands(),
  });

  const brandCards: IBrandCardProps[] = useMemo(() => {
    if (!brands) return [];
    let list = brands;
    if (search.trim()) {
      const q = search.trim().toLowerCase();
      list = list.filter(
        (b) =>
          b.name.toLowerCase().includes(q) ||
          b.slug?.toLowerCase().includes(q),
      );
    }
    return list.map((b) => ({
      id: b.id,
      name: b.name,
      logo: getImageUrl(b.logo) || APP_IMAGES.BRAND_PLACEHOLDER,
      onClick: () => navigate(`/cars?brands=${b.id}`),
    }));
  }, [brands, search, navigate]);

  return { brandCards, search, setSearch, isLoading };
}
