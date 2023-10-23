namespace World
{

    public class Item
    {
        private string name;

        private string description;

        public Item(string name, string description)
        {
            this.name = name;
            this.description = description;
        }


        public string GetName()
        {
            return name;
        }

        public string GetDescription()
        {
            return description;
        }
    }

}
