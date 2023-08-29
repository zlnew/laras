function toInt (string: string): number {
  if (string === null) {
    return 0
  }
  return parseInt(string)
}

function toFloat (string: string): number {
  if (string === null) {
    return 0
  }
  return parseFloat(string)
}

async function sanitizeUsNumber (amount: string): Promise<number> {
  const input = amount.replace(/,/g, '')
  const formattedAmount = parseFloat(input).toFixed(2)

  return toFloat(formattedAmount)
}

export {
  toInt,
  toFloat,
  sanitizeUsNumber
}
