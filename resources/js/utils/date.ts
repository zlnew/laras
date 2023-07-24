import { DateTime } from "luxon";

function getEndOfDate(startDate: string, daysDuration: number): string {
  const [day, month, year] = startDate.split('-');

  const startOfDate = DateTime.fromObject({
    day: parseInt(day),
    month: parseInt(month),
    year: parseInt(year)
  });

  const endOfDate = startOfDate.plus({
    days: daysDuration
  });
  
  const formattedEndOfDate = endOfDate.toFormat('dd-MM-yyyy');

  return formattedEndOfDate;
}

function countDaysBetweenDates(startDateStr: string, endDateStr: string): number {
  const [startDay, startMonth, startYear] = startDateStr.split('-');
  const [endDay, endMonth, endYear] = endDateStr.split('-');

  const startDate = DateTime.fromObject({
    day: parseInt(startDay),
    month: parseInt(startMonth),
    year: parseInt(startYear),
  });
  
  const endDate = DateTime.fromObject({
    day: parseInt(endDay),
    month: parseInt(endMonth),
    year: parseInt(endYear),
  });

  const diffInDays = endDate.diff(startDate, 'days').days;

  return diffInDays;
}

export {
  getEndOfDate,
  countDaysBetweenDates
}