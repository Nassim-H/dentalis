const Input = ({ label, type = "text", name, placeholder }) => {
    return (
      <div className="mb-4">
        <label className="block text-dark font-medium">{label}</label>
        <input
          type={type}
          name={name}
          placeholder={placeholder}
          className="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary"
        />
      </div>
    );
  };
  
  export default Input;
  