namespace SchoolLibs;
public class Student
{

    private string firstName;

    private string lastName;

    private DateTime registrationDate;

    public Student(string firstName, string lastName, DateTime registrationDate)
    {
        this.firstName = firstName ?? throw new ArgumentNullException(nameof(firstName));
        this.lastName = lastName ?? throw new ArgumentNullException(nameof(lastName));
        this.registrationDate = registrationDate;
    }

    public string PrettyString()
    {
        return $"{this.firstName}, {this.lastName} ({this.registrationDate})";
    }
}

