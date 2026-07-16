export interface IOfferListCardProps {
  id: string | number;
  image: string;
  title: string;
  description: string;
  priceLabel: string;
  price: number;
  priceUnit?: string;
  buttonText: string;
  buttonTo: string;
}
