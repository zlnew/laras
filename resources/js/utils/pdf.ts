import JsPDF from 'jspdf'
import autoTable, { type ColumnInput, type RowInput } from 'jspdf-autotable'
import { DateTime } from 'luxon'

interface Export {
  filename: string
  header?: string
  columns: [ { label: string, name: string } ]
  body: {
    rows: any[]
    props: string[]
  }
}

interface Body {
  rows: any[]
  props: string[]
  index?: boolean
}

function createColumns (keys: Export['columns']): ColumnInput[] {
  const columns = [] as ColumnInput[]
  keys.forEach(key => {
    columns.push({
      header: key.label,
      dataKey: key.name
    })
  })
  return columns
}

function createBody (data: Body): RowInput[] {
  return data.rows.map((row, index) => {
    const filteredRow: RowInput = {}
    data.props.forEach((prop) => {
      // eslint-disable-next-line @typescript-eslint/strict-boolean-expressions, no-prototype-builtins
      if (row.hasOwnProperty(prop)) {
        filteredRow[prop] = row[prop]
      }
    })
    if (data.index !== undefined) {
      filteredRow.index = ++index
    }
    return filteredRow
  })
}

function tableToPdf (data: Export) {
  const doc = new JsPDF()
  const now = DateTime.now().toISODate()
  // eslint-disable-next-line @typescript-eslint/restrict-template-expressions
  const fileName = `${now}_${data.filename}.pdf`
  const columns = createColumns(data.columns)
  const body = createBody({
    rows: data.body.rows,
    props: data.body.props,
    index: true
  })
  autoTable(doc, {
    columns,
    body
  })
  doc.save(fileName)
}

export {
  tableToPdf,
  createColumns,
  createBody
}
