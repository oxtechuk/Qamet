import { useState } from "react";
import { useTranslation } from "react-i18next";
import { CalendarDays, Car, Gauge, RotateCcw, Search, Tag } from "lucide-react";
import Select from "./Select";
import type { ICarFinderProps } from "../interfaces/ICarFinderProps";

function getLocalizedName(
    name: string | Record<string, string> | undefined,
    lang: string,
): string {
    if (!name) return "";
    if (typeof name === "string") return name;
    return name[lang] ?? name["en"] ?? "";
}

export default function CarFinder({
    onSearch,
    onReset,
    brands = [],
    types = [],
    categories = [],
    years = [],
    filterTitle,
}: ICarFinderProps) {
    const { t, i18n } = useTranslation();
    const [brandId, setBrandId] = useState("");
    const [typeId, setTypeId] = useState("");
    const [categoryId, setCategoryId] = useState("");
    const [yearVal, setYearVal] = useState("");
    const [searchText, setSearchText] = useState("");

    const handleSearch = () => {
        onSearch?.({
            brandId,
            typeId,
            categoryId,
            year: yearVal,
            search: searchText,
        });
    };

    const handleReset = () => {
        setBrandId("");
        setTypeId("");
        setCategoryId("");
        setYearVal("");
        setSearchText("");
        onReset?.();
    };

    return (
        <section
            dir={i18n.dir()}
            className="w-full py-5"
            style={{ background: "transparent" }}
        >
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 className="mb-8 text-center text-[28px] font-bold text-white">
                    {filterTitle || t("carFinder.title")}
                </h2>
                <div className="mt-7 grid grid-cols-1 gap-4 lg:grid-cols-4 mb-3">
                    <div className="relative lg:col-span-2">
                        <input
                            type="text"
                            value={searchText}
                            onChange={(e) => setSearchText(e.target.value)}
                            placeholder={t("carFinder.searchPlaceholder")}
                            onKeyDown={(e) =>
                                e.key === "Enter" && handleSearch()
                            }
                            className="h-[52px] w-full rounded-[8px] border border-[#D7E3F5] bg-white px-5 pr-11 text-sm text-[#111827] outline-none placeholder:text-[#4B8FEA] focus:border-[var(--brand-primary-color)] focus:ring-2 focus:ring-[rgba(41,155,224,0.25)]"
                        />

                        <Search
                            size={18}
                            className="absolute right-4 top-1/2 -translate-y-1/2 text-[#4B8FEA]"
                        />
                    </div>

                    <button
                        type="button"
                        onClick={handleSearch}
                        className="h-[52px] rounded-[8px] bg-[var(--brand-secondary-color)] text-base font-medium text-white transition hover:opacity-90"
                    >
                        {t("carFinder.searchButton")}
                    </button>

                    <button
                        type="button"
                        onClick={handleReset}
                        className="flex h-[52px] items-center justify-center gap-2 rounded-[8px] border border-[var(--brand-secondary-color)] text-base font-medium text-[var(--brand-secondary-color)] transition hover:bg-[var(--brand-secondary-color)] hover:text-white"
                    >
                        <RotateCcw size={17} />
                        {t("carFinder.resetButton")}
                    </button>
                </div>

                <div className="grid grid-cols-2 gap-6 md:grid-cols-2 lg:grid-cols-4 ">
                    <div className="w-full">
                        <label className=" block text-center text-[13px] font-medium text-white">
                            {t("carFinder.brand")}
                        </label>
                        <Select
                            searchable
                            placeholder={t("carFinder.brandPlaceholder")}
                            value={brandId}
                            onChange={setBrandId}
                            options={brands.map((b) => ({
                                label: getLocalizedName(b.name, i18n.language),
                                value: String(b.id),
                            }))}
                            icon={<Tag size={18} className="text-[#FF4A4A]" />}
                            className="h-[52px] rounded-[8px] border border-[#D7E3F5] bg-white text-sm text-[#111827]"
                        />
                    </div>

                    <div className="w-full">
                        <label className="block text-center text-[13px] font-medium text-white">
                            {t("carFinder.type")}
                        </label>
                        <Select
                            searchable
                            placeholder={t("carFinder.typePlaceholder")}
                            value={typeId}
                            onChange={setTypeId}
                            options={types.map((t) => ({
                                label: getLocalizedName(t.name, i18n.language),
                                value: String(t.id),
                            }))}
                            icon={<Car size={18} className="text-[#B84DFF]" />}
                            className="h-[52px] rounded-[8px] border border-[#D7E3F5] bg-white text-sm text-[#111827]"
                        />
                    </div>

                    <div className="w-full">
                        <label className="block text-center text-[13px] font-medium text-white">
                            {t("carFinder.category")}
                        </label>
                        <Select
                            searchable
                            placeholder={t("carFinder.categoryPlaceholder")}
                            value={categoryId}
                            onChange={setCategoryId}
                            options={categories.map((c) => ({
                                label: getLocalizedName(c.name, i18n.language),
                                value: String(c.id),
                            }))}
                            icon={
                                <CalendarDays
                                    size={18}
                                    className="text-[#3B82F6]"
                                />
                            }
                            className="h-[52px] rounded-[8px] border border-[#D7E3F5] bg-white text-sm text-[#111827]"
                        />
                    </div>

                    <div className="w-full">
                        <label className=" block text-center text-[13px] font-medium text-white">
                            {t("carFinder.year")}
                        </label>
                        <Select
                            searchable
                            placeholder={t("carFinder.yearPlaceholder")}
                            value={yearVal}
                            onChange={setYearVal}
                            options={years.map((y) => {
                                const val =
                                    typeof y === "string"
                                        ? y
                                        : (y?.year ?? String(y));
                                return { label: val, value: val };
                            })}
                            icon={
                                <Gauge size={18} className="text-[#FF3FB4]" />
                            }
                            className="h-[52px] rounded-[8px] border border-[#D7E3F5] bg-white text-sm text-[#111827]"
                        />
                    </div>
                </div>
            </div>
        </section>
    );
}
