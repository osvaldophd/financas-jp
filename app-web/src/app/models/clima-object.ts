export interface ClimaObject {
  cod:     string;
  message: number;
  cnt:     number;
  list:    List[];
  city:    City;
}

export interface ClimaObject {
  cod:     string;
  message: number;
  cnt:     number;
  list:    List[];
  city:    City;
}

export interface City {
  id:         number;
  name:       string;
  coord:      Coord;
  country:    string;
  population: number;
  timezone:   number;
  sunrise:    number;
  sunset:     number;
}

export interface Coord {
  lat: number;
  lon: number;
}

export interface List {
  dt:      number;
  main:    MainClass;
  weather: Weather[];
  clouds:  Clouds;
  wind:    Wind;
  sys:     Sys;
  dt_txt:  Date;
  rain?:   Rain;
}

export interface Clouds {
  all: number;
}

export interface MainClass {
  temp:       number;
  temp_min:   number;
  temp_max:   number;
  pressure:   number;
  sea_level:  number;
  grnd_level: number;
  humidity:   number;
  temp_kf:    number;
}

export interface Rain {
  "3h": number;
}

export interface Sys {
  pod: Pod;
}

export enum Pod {
  D = "d",
  N = "n",
}

export interface Weather {
  id:          number;
  main:        string;
  description: string;
  icon:        string;
}

export interface Wind {
  speed: number;
  deg:   number;
}
