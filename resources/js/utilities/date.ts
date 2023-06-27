import moment from "moment";

moment.locale('id');

export const revertDate = (formattedDate: string) => {
    if (formattedDate) {
        return moment(formattedDate, 'll').format('YYYY-MM-DD');
    }
}

export const ll = (date: string | Date) => {
    return moment(date).format("ll");
}