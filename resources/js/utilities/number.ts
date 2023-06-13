export const toRupiah = (amount: number | null) => {
    if (amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
        }).format(amount);
    }
}

export const fromRupiah = (formattedAmount: string | null) => {
    if (formattedAmount) {
        const cleanedAmount = formattedAmount.replace(/[^\d,-]/g, "").replace(",", ".");
        return parseFloat(cleanedAmount);
    }
}