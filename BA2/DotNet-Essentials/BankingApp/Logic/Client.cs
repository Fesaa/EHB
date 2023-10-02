namespace HelperLibs;

public class Client
{
    private string firstName;
    private string lastName;

    public Client(string firstName, string lastName)
    {
        this.firstName = firstName;
        this.lastName = lastName;
    }

    public override string ToString()
    {
        return $"@Client{{<firstName: {this.firstName}>,<lastName: {this.lastName}>}}";
    }
}
