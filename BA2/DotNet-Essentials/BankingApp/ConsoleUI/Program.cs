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

        // 4 & 5 shortcut bruh
        Client me = new Client("Testing", "Popping");
        Client notMe = new Client("???", "OOIII");

        List<Account> accounts = new List<Account>();
        accounts.Add(new RegularAccount("myCustomIBAN", 2000, 2, me));
        accounts.Add(new RegularAccount("myCustomIBAN2", 1000, 5, notMe));
        accounts.Add(new SavingAccount("mySavingsIBAN", 10000, 5, 2, me));

        accounts.ForEach(acc =>
        {
            Console.WriteLine(acc);
        });

    }

    private static void Oef4()
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

        Client client = new Client("", "");

        Account account = accountType.Equals("1") ?
                new RegularAccount(iban, DEFAULT_BALANCE, DEFAULT_INTEREST, client) :
                new SavingAccount(iban, DEFAULT_BALANCE, DEFAULT_INTEREST, 2, client);

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
