import exportFromJSON from 'export-from-json'

interface Props {
  data: any[]
  name?: string
  type?: 'csv' | 'xls'
}

const excelParser = () => {
  function exportDataFromJSON (props: Props) {
    if (props.data.length < 1) return
    try {
      const fileName = props.name !== null ? props.name : 'exported-data'
      const exportType = exportFromJSON.types[props.type !== undefined ? props.type : 'xls']
      exportFromJSON({
        data: props.data,
        fileName,
        exportType
      })
    } catch (e) {
      throw new Error('Parsing failed!')
    }
  }
  return {
    exportDataFromJSON
  }
}

export {
  excelParser
}
