using System;
using System.Collections.Generic;

namespace Vector
{
    public class Email
    {
        public string Onderwerp { get; set; }
        public string Inhoud { get; set; }
        public string Afzender { get; set; }
        public List<string> Ontvanger { get; set; }
        public DateTime Datum { get; set; }

        public Email(string onderwerp, string inhoud, string afzender, List<string> ontvanger, DateTime datum)
        {
            Onderwerp = onderwerp;
            Inhoud = inhoud;
            Afzender = afzender;
            Ontvanger = ontvanger;
            Datum = datum;
        }

        public override string ToString()
        {
            return $"Onderwerp: {Onderwerp}\nInhoud: {Inhoud}\nAfzender: {Afzender}\nOntvanger: {Ontvanger}\nDatum: {Datum}";
        }
    }
}
