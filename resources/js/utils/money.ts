import { toFloat } from './number'

function fromRupiah (formattedAmount: string) {
  const sanitizedAmount = formattedAmount
    .replace(/[^\d,-]/g, '')
    .replace(',', '.')
  return toFloat(sanitizedAmount)
}

function toRupiah (amount: number) {
  const formattedAmount = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR'
  }).format(amount)
  return formattedAmount
}

export {
  fromRupiah,
  toRupiah
}
