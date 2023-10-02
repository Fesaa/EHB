namespace Program;

using HelperLibs;

class Program
{

    private static readonly string WELCOME_TEXT = @"
Welcome to a simple Banking App sim in the command line.
Choose your acount type:
1) Normal Account
2) Savings Account
... ";

    private static readonly string INBAN_TEXT = "Provide your IBAN number: ";
    private static readonly string ACCOUNT_NUMBER_TEXT = "Provide an account number to add to your account: ";

    private static readonly string INVALID_INPUT =
        "Received invalid input... exiting program.";


    private static readonly double DEFAULT_BALANCE = 2000;
    private static readonly double DEFAULT_INTEREST = 1;

    public static void Main(string[] _)
    {
        Console.Write(WELCOME_TEXT);

        string? accountType = Console.ReadLine();
        if (accountType == null || !(accountType.Equals("1") || accountType.Equals("2")))
        {
            Console.WriteLine(INVALID_INPUT);
            return;
        }

        Console.WriteLine(INBAN_TEXT);
        string? iban = Console.ReadLine();
        if (iban == null)
        {
            Console.WriteLine(INVALID_INPUT);
            return;
        }

        Account account = accountType.Equals("1") ?
                new RegularAccount(iban, DEFAULT_BALANCE, DEFAULT_INTEREST) :
                new SavingAccount(iban, DEFAULT_BALANCE, DEFAULT_INTEREST);

        if (account is RegularAccount rAccount)
        {
            account = doAccountNumberLoop(rAccount);
        }

        Console.WriteLine(account.ToString());
    }



    private static RegularAccount doAccountNumberLoop(RegularAccount acc)
    {
        while (true)
        {
            Console.WriteLine(ACCOUNT_NUMBER_TEXT);
            string? accountNumber = Console.ReadLine();
            if (accountNumber == null)
            {
                Console.WriteLine(INVALID_INPUT);
                return acc;
            }
            if (accountNumber.Equals("q"))
            {
                return acc;
            }
            acc.registerAccountNumber(accountNumber);
        }
    }

}
