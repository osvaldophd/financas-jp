import { Contacto } from './contacto.model';

export class Vans {
    id: number;
    matricula: string;
    descricao: string;
    modelo: string;
    marca: string;
    created_at: string;
    updated_at: string;
    contactos: Contacto;
}