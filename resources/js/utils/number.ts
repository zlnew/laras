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

export {
  toInt,
  toFloat
}
