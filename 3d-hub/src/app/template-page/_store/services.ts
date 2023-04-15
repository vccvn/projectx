import { CategoryService } from "@app/_store/category";
import { TemplateService } from "@app/_store/template";
import { TemplateTableService } from "@app/_store/template/table";
// import { TemplateEventsService } from "./events.service";

export const services = [
  TemplateService,
  CategoryService,
  
  TemplateTableService,
];
