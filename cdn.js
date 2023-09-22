const MONTHS = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];

  function months(config) {
    var cfg = config || {};
    var count = cfg.count || 12;
    var section = cfg.section;
    var values = [];
    var i, value;

    for (i = 0; i < count; ++i) {
      value = MONTHS[Math.ceil(i) % 12];
      values.push(value.substring(0, section));
    }

    return values;
  };
  var currentMonth=new Date().getMonth()+1;

  var currentYear=new Date().getFullYear();

  const getAllDaysInMonth = (month, year) =>
  Array.from(
    {length: new Date(year, month, 0).getDate()}, // get next month, zeroth's (previous) day
    (_, i) => new Date(year, month - 1, i + 1)    // get current month (0 based index)
  );

const allDatesInMonth = getAllDaysInMonth(currentMonth, currentYear);
var thisMonthArray=allDatesInMonth.map(x => x.toLocaleDateString([], {weekday: 'short', day: "numeric" }));


var randomArray = [];

for (var i = 0; i < 20; i++) {
  var randomValue = Math.floor(Math.random() * 500); // Generates random numbers between 0 and 99
  randomArray.push(randomValue);
}
