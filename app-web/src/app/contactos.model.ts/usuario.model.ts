import { Roles } from './roles.model';

export class Usuario {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    roles: Roles;
}