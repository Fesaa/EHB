using System;
using System.ComponentModel.DataAnnotations;

namespace Course20240222.Models
{
	public class PizzaModel
	{

		public string Besteller { get; set; } = string.Empty;
		public string Pizza { get; set; } = string.Empty;
		public bool ExtraKaas { get; set; }
		public BetaalWijze BetaalWijze { get; set; }


		public bool IsValid()
		{
			return !(string.IsNullOrEmpty(Besteller)
				|| string.IsNullOrEmpty(Pizza));
		}
	}


	public enum BetaalWijze
	{
		[Display(Name = "Cash")] CASH,
        [Display(Name = "Bankcontact")] BANKCONTACT,
        [Display(Name = "Overschrijving")] OVERSCHRIJVING
	}
}

