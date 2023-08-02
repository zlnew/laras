function toInt(string: string): number {
  return parseInt(string);
}

function toFloat(string: string): number {
  return parseFloat(string);
}

function toMultiInt(array: string[]): number[] {
  return array.map(val => {
    return parseInt(val);
  });
}

function toMultiFloat(array: string[]): number[] {
  return array.map(val => {
    return parseFloat(val);
  });
}

export {
  toInt,
  toFloat,
  toMultiInt,
  toMultiFloat
}