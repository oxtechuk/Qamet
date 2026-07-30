import { useEffect, useRef, useState } from "react";
import { getCars, searchCars } from "../services/api";
import type { CarItem } from "../types/home.types";

export function useCarSearch(showSearch: boolean) {
  const [searchQuery, setSearchQuery] = useState("");
  const [searchResults, setSearchResults] = useState<CarItem[]>([]);
  const [searching, setSearching] = useState(false);
  const searchTimer = useRef<ReturnType<typeof setTimeout>>(undefined);

  useEffect(() => {
    if (!showSearch) return;
    if (!searchQuery.trim()) {
      getCars()
        .then((res) => setSearchResults(res.data))
        .catch(() => setSearchResults([]));
      return;
    }
    clearTimeout(searchTimer.current);
    searchTimer.current = setTimeout(async () => {
      setSearching(true);
      try {
        const results = await searchCars(searchQuery);
        setSearchResults(results);
      } catch {
        setSearchResults([]);
      } finally {
        setSearching(false);
      }
    }, 300);
    return () => clearTimeout(searchTimer.current);
  }, [searchQuery, showSearch]);

  return { searchQuery, setSearchQuery, searchResults, setSearchResults, searching };
}
