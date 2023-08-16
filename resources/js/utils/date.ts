import { DateTime } from 'luxon';

const config = {
  locale: 'id'
};

function fullDate (date: string | null): string | null {
  if (date) {
    const formattedDate = DateTime.fromSQL(date).setLocale(config.locale).toLocaleString(DateTime.DATE_FULL);
    return formattedDate;
  }
  return date;
};

function daysDiff (startDate: string, endDate: string): number {
  const start = DateTime.fromSQL(startDate);
  const end = DateTime.fromSQL(endDate);
  const diff = end.diff(start, 'days');
  return diff.as('days');
}

function endOfDate (startDate: string, days: number): string | null{
  const start = DateTime.fromSQL(startDate);
  const end = start.plus({
    days: days - 1
  });
  return end.toSQLDate();
}

export {
  fullDate,
  daysDiff,
  endOfDate,
}
