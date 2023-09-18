import { invoices } from "./index.vue";

export const getInvoices = async () => {
let respone = await axios.get("/api/get_all_invoices");

invoices.value = respone.data.invoices;
};
