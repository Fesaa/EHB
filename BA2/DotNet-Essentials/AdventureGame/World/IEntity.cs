namespace World
{
    public interface IEntity
    {
        string GetName();

        double GetHealth();

        void SetHealth(double health);

        double GetAttack();

        void SetAttack(double attack);

        double GetDefense();

        void SetDefense(double defense);

        bool TakeDamage(IEntity attacker);

        void die();
    }
}
