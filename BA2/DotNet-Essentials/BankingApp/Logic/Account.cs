namespace HelperLibs;

public abstract class Account
{

    private static readonly double MIN_BALANCE_AMOUNT = -1000;

    public abstract string AccountType { get; }

    private string IBAN;
    private double balance;
    private DateTime creationDate;
    private double interest;

    protected Account(
        string IBAN, double balance, DateTime creationDate, double interest)
    {
        this.IBAN = IBAN;
        this.balance = balance;
        this.creationDate = creationDate;
        this.interest = interest;
    }

    /// <param name="amount"> Amount to deposit</param>
    /// <exception cref="Exception">
    /// Will throw an exception if <paramref name="amount"/> is less then zero
    /// </exception>
    public double deposit(double amount)
    {
        if (amount < 0)
        {
            throw new Exception($"Deposit cannot be less than zero. {amount}");
        }

        this.balance += amount;
        return this.balance;
    }

    /// <param name="amount"> Amount to withdraw</param>
    /// <exception cref="Exception">
    /// Will throw an exception if <paramref name="amount"/> is less then zero
    /// Or if withdrawing would put balance under <see cref="MIN_BALANCE_AMOUNT">
    /// </exception>
    public double withdraw(double amount)
    {
        if (amount < 0)
        {
            throw new Exception($"Deposit cannot be less than zero. {amount}");
        }
        if (this.balance - amount < MIN_BALANCE_AMOUNT)
        {
            throw new Exception($"Cannot withdraw {amount}, would lower your balance under {MIN_BALANCE_AMOUNT}");
        }

        this.balance -= amount;
        return this.balance;
    }

    public override string ToString()
    {
        return $"@Account{{<IBAN: {this.IBAN}>, <balance: {this.balance}>, <creationDate: {this.creationDate.ToString()}>, <interest: {this.interest}>, <Hash: {this.GetHashCode()}>}}";
    }

}

