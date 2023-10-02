namespace HelperLibs;

public class RegularAccount : Account
{

    // Most ugly syntax I've ever seen
    // What's wrong with just fields and a getter at this point
    // This should just be a method either way LOL
    // getAccountType tf is this nonsens
    public override string AccountType
    {
        get
        {
            return "REGULAR";
        }
    }

    private List<string> accountNumbers;

    public RegularAccount(string IBAN, double balance, double interest, Client client)
        : base(IBAN, balance, DateTime.Now, interest, client)
    {
        this.accountNumbers = new List<string>();
    }

    /// <param name="accountNumber">AccountNumber code to register</param>
    /// <returns bool> Wether the number was added (false if already present) </returns>
    public bool registerAccountNumber(string accountNumber)
    {
        if (this.accountNumbers.Contains(accountNumber))
        {
            return false;
        }
        this.accountNumbers.Add(accountNumber);
        return true;
    }

    /// <param name="accountNumber">AccountNumber code to unregister</param>
    /// <returns bool> Wether the number was removed (false if not present) </returns>
    public bool unregisterAccountNumber(string accountNumber)
    {
        return this.accountNumbers.Remove(accountNumber);
    }

    public override string ToString()
    {
        return $"@RegularAccount{{<accountNumbers: {String.Join(",", this.accountNumbers.ToArray())}>, <base: {base.ToString()}>}}";
    }

}
