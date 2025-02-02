export const stateMappings = {
    confirmed: "ފައިސާ ލިބިއްޖެ",
    pending: "ފައިސާ ނުދައްކާ",
    cancelled: "ކެންސަލްވެފައި",
    paid: "ފައިސާ ދައްކާފައި",
    overdue: "މުއްދަތު ހަމަވެފައި",
    partially_paid: "އެއްކޮށް ނުދައްކާ",
    written_off: "މަޢާފު ކުރެވިފައި",
};

export const payableStates = {
    completed: ["paid", "cancelled", "written_off"],
    pending: ["pending", "partially_paid", "written_off"],
    overdue: ["overdue"],
};

export const paymentStates = {
    completed: ["confirmed"],
    pending: ["pending"],
    cancelled: ["cancelled"],
};
