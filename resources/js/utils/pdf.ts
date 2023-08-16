import jsPDF from 'jspdf';
import autoTable, { ColumnInput, RowInput } from 'jspdf-autotable';

interface Export {
  filename: string;
  header?: string;
  columns: [ { label: string, name: string } ];
  body: {
    rows: any[];
    props: string[];
  };
}

interface Body {
  rows: any[],
  props: string[],
  index?: boolean
}

function createColumns (keys: Export['columns']): ColumnInput[] {
  let columns = [] as ColumnInput[];
  keys.forEach(key => {
    columns.push({
      header: key.label,
      dataKey: key.name
    });
  });
  return columns;
}

function createBody (data: Body): RowInput[] {
  return data.rows.map((row, index) => {
    const filteredRow: RowInput = {};
    data.props.forEach((prop) => {
      if (row.hasOwnProperty(prop)) {
        filteredRow[prop] = row[prop];
      }
    });
    if (data.index) {
      filteredRow['index'] = ++index;
    }
    return filteredRow;
  });
}

function tableToPdf (data: Export) {
  const doc = new jsPDF();
  const now = new Date();
  const columns = createColumns(data.columns);
  const body = createBody({
    rows: data.body.rows,
    props: data.body.props,
    index: true
  });
  autoTable(doc, {
    columns: columns,
    body: body,
  });
  doc.save(`${now.toDateString()}_${data.filename}.pdf`);
}

export {
  tableToPdf,
  createColumns,
  createBody
}
