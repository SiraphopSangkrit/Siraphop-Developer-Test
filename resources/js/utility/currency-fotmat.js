export const formatPrice = (price) => {
    return new Intl.NumberFormat('th-TH', {
        currency: 'THB',
    }).format(price);
};
