const filterOptions = (val: string, options: any[]) => {
  if (val === '') {
    return options;
  }

  const needle = val.toLowerCase();

  return options.filter((v) => v.toLowerCase().indexOf(needle) > -1);
}

function createOptions(rows: any[], label: string) {
  const optionsObj = rows.reduce((group: any, row) => {
    group[row[label]] = [];
    group[row[label]].push(row[label]);
  
    return group;
  }, {});

  return Object.keys(optionsObj);
}

export {
  filterOptions,
  createOptions
};