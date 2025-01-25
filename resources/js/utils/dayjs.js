import dayjs from "dayjs";
import localeData from "dayjs/plugin/localeData";

dayjs.extend(localeData);

dayjs.locale("dv", {
    name: "dv",
    weekdays: [
        "އާދީއްތަ",
        "ހޯމަ",
        "އަންގާރައި",
        "ބުދަ",
        "ބުރާސްފަތި",
        "ހުކުރު",
        "ހޮނިހިރު",
    ],
    months: [
        "ޖަނަވަރީ",
        "ފެބުރުއަރީ",
        "މާރޗް",
        "އޭޕްރީލް",
        "މޭ",
        "ޖޫން",
        "ޖުލައި",
        "އޯގަސްޓު",
        "ސެޕްޓެމްބަރު",
        "އޮކްޓޫބަރު",
        "ނޮވެމްބަރު",
        "ޑިސެމްބަރު",
    ],
    weekStart: 7, // Week starts on Sunday
    formats: {
        LT: "HH:mm",
        LTS: "HH:mm:ss",
        L: "DD/MM/YYYY",
        LL: "D MMMM YYYY",
        LLL: "D MMMM YYYY HH:mm",
        LLLL: "dddd, D MMMM YYYY HH:mm",
    },
    relativeTime: {
        future: "%sފަހަރު",
        past: "%s ކުރިން",
        s: "ސިކަންތައް",
        m: "މިނެޓެއް",
        mm: "%d މިނެޓު",
        h: "ގަޑިއެއް",
        hh: "%d ގަޑި",
        d: "ދުވަހެއް",
        dd: "%d ދުވަސް",
        M: "މަހެއް",
        MM: "%d މަސް",
        y: "އަހަރެއް",
        yy: "%d އަހަރު",
    },
});

dayjs.locale("dv");

export default dayjs;
