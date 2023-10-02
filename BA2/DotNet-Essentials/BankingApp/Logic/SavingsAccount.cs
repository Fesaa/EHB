namespace HelperLibs;

public class SavingAccount : Account
{

    public override string AccountType
    {
        get
        {
            return "SAVINGS";
        }
    }

    private static readonly double DEFAULT_BONUS = 2;

    private double loyaltyBonus;

    public SavingAccount(string IBAN, double balance, double interest, double loyaltyBonus, Client client)
        : base(IBAN, balance, DateTime.Now, interest, client)
    {
        this.loyaltyBonus = loyaltyBonus;
    }

    public override string ToString()
    {
        return $"@SavingsAccount{{<layaltyBonus: {this.loyaltyBonus}>, <Base: {base.ToString()}>}}";
    }

}
