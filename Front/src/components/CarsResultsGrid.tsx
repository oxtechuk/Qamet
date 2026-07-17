import CarCard from "./CarCard";
import type { ICarsResultsGridProps } from "../interfaces/ICarsResultsGridProps";

export default function CarsResultsGrid({
  cars,
  currentPage,
  totalPages,
  onPageChange,
}: ICarsResultsGridProps) {
  const pages = Array.from({ length: totalPages }, (_, index) => index + 1);

  const handlePrev = () => {
    if (currentPage > 1) {
      onPageChange(currentPage - 1);
    }
  };

  const handleNext = () => {
    if (currentPage < totalPages) {
      onPageChange(currentPage + 1);
    }
  };

  return (
    <section className="w-full">
      {/* Cars Grid */}
      <div className="grid grid-cols-1 items-stretch gap-7 md:grid-cols-2 xl:grid-cols-3 justify-items-center">
        {cars.map((car) => (
          <CarCard key={car.id} {...car} />
        ))}
      </div>

      {/* Pagination */}
      <div className="mt-14 flex items-center justify-center gap-3" dir="ltr">
        <button
          type="button"
          onClick={handlePrev}
          disabled={currentPage === 1}
          className="flex h-[50px] w-[50px] items-center justify-center rounded-[14px] border border-[#D8DDE5] bg-white text-[#111827] transition hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)] disabled:cursor-not-allowed disabled:opacity-50"
        >
{'\u003C'}
        </button>

        {pages.map((page) => {
          const isActive = page === currentPage;

          return (
            <button
              key={page}
              type="button"
              onClick={() => onPageChange(page)}
              className={`flex h-[50px] w-[50px] items-center justify-center rounded-[14px] border text-[18px] font-bold transition ${
                isActive
                  ? "border-[var(--brand-primary-color)] bg-[var(--brand-primary-color)] text-white"
                  : "border-[#D8DDE5] bg-white text-[#5B6470] hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)]"
              }`}
            >
              {page}
            </button>
          );
        })}

        <button
          type="button"
          onClick={handleNext}
          disabled={currentPage === totalPages}
          className="flex h-[50px] w-[50px] items-center justify-center rounded-[14px] border border-[#D8DDE5] bg-white text-[#111827] transition hover:border-[var(--brand-primary-color)] hover:text-[var(--brand-primary-color)] disabled:cursor-not-allowed disabled:opacity-50"
        >
{'\u003E'}
        </button>
      </div>
    </section>
  );
}
