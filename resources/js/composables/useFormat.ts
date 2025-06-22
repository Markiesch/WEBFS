const formatPrice = (price: number) => {
    return new Intl.NumberFormat('nl', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2,
    }).format(price);
};

const formatDate = (date: string | Date) => {
    return new Intl.DateTimeFormat('nl', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }).format(new Date(date));
}

export function useFormat() {
    return { formatPrice, formatDate };
}
