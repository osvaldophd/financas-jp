import { Morada } from 'src/app/models/morada.model';
import { Contacto } from './contacto.model';
import { Usuario } from 'src/app/contactos.model.ts/usuario.model';

export class Funcionarios {
    id: number;
    nome: string;
    nacionalidade: string;
    genero: string;
    data_nascimento: string;
    usuario_id: number
    created_at: string;
    updated_at: string;
    usuario: Usuario;
    contactos: Contacto;
    morada: Morada;
}
